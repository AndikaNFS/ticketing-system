<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Outlet;
use App\Models\InventoryTransfer;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetMovementSheetImport implements
    ToCollection,
    WithHeadingRow,
    WithTitle
{
    public function title(): string
    {
        return 'Asset Movement';
    }

    public function collection(Collection $rows)
    {
        $processedRefs = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            $assetRef = $this->nullableString($row['asset_ref'] ?? null);
            $fromOutletName = $this->nullableString($row['from_outlet'] ?? null);
            $toOutletName = $this->nullableString($row['to_outlet'] ?? null);
            $transferDate = $this->parseDate($row['transfer_date'] ?? null);
            $description = $this->nullableString($row['description'] ?? null);

            // Lewati baris yang benar-benar kosong
            $hasData = collect($row->toArray())->contains(
                fn ($value) => $value !== null && trim((string) $value) !== ''
            );

            // Lewati baris jika seluruh kolom Asset Movement kosong
            if (!$assetRef && !$fromOutletName && !$toOutletName && !$row['transfer_date'] && !$description) {
                continue;
            }

            // Validasi kolom wajib
            $errors = [];

            if (!$assetRef) {
                $errors[] = 'Asset Ref wajib diisi.';
            }

            if (!$fromOutletName) {
                $errors[] = 'From Outlet wajib diisi.';
            }

            if (!$toOutletName) {
                $errors[] = 'To Outlet wajib diisi.';
            }

            if (!$transferDate) {
                $errors[] = 'Transfer Date wajib diisi dengan tanggal yang valid.';
            }

            if ($errors) {
                $this->fail($rowNumber, $errors);
            }

            // Cegah satu asset dipindahkan dua kali dalam satu sheet
            if (in_array($assetRef, $processedRefs, true)) {
                $this->fail($rowNumber, [
                    "Asset Ref {$assetRef} muncul lebih dari satu kali.",
                ]);
            }

            $processedRefs[] = $assetRef;

            // Cari asset dan kunci record selama transaksi berjalan
            $asset = Asset::where('import_ref', $assetRef)
                ->lockForUpdate()
                ->first();

            if (!$asset) {
                $this->fail($rowNumber, [
                    "Asset dengan Asset Ref {$assetRef} tidak ditemukan.",
                ]);
            }

            // Cari outlet asal dan tujuan berdasarkan nama
            $fromOutlet = Outlet::where('name', $fromOutletName)->first();
            $toOutlet = Outlet::where('name', $toOutletName)->first();

            if (!$fromOutlet) {
                $this->fail($rowNumber, [
                    "From Outlet '{$fromOutletName}' tidak ditemukan.",
                ]);
            }

            if (!$toOutlet) {
                $this->fail($rowNumber, [
                    "To Outlet '{$toOutletName}' tidak ditemukan.",
                ]);
            }

            // Pastikan outlet asal sesuai lokasi asset saat ini
            if ((int) $asset->outlet_id !== (int) $fromOutlet->id) {
                $this->fail($rowNumber, [
                    "Asset {$assetRef} saat ini berada di outlet "
                    . ($asset->outlet->name ?? 'tidak diketahui')
                    . ", bukan {$fromOutletName}.",
                ]);
            }

            // Outlet asal dan tujuan tidak boleh sama
            if ($fromOutlet->id === $toOutlet->id) {
                $this->fail($rowNumber, [
                    'From Outlet dan To Outlet tidak boleh sama.',
                ]);
            }

            // Asset dengan status tertentu tidak boleh dipindahkan
            if (in_array(
                strtolower($asset->status),
                ['repair', 'lost', 'disposed'],
                true
            )) {
                $this->fail($rowNumber, [
                    "Asset {$assetRef} dengan status {$asset->status} "
                    . 'tidak dapat dipindahkan.',
                ]);
            }

            // Catat riwayat perpindahan
            InventoryTransfer::create([
                'inventory_id' => $asset->inventory_id,
                'asset_id' => $asset->id,
                'from_outlet_id' => $fromOutlet->id,
                'to_outlet_id' => $toOutlet->id,
                'quantity' => 1,
                'transfer_date' => $transferDate,
                'status' => 'completed',
                'description' => $description,
                'created_by' => Auth::id(),
            ]);

            // Update lokasi asset
            $asset->update([
                'outlet_id' => $toOutlet->id,
            ]);
        }
    }

    private function nullableString($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function parseDate($value): ?string
    {
        if (!$value) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(
                    Date::excelToDateTimeObject($value)
                )->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Throwable $e) {
            return null;
        }
    }

    private function fail(int $rowNumber, array $errors): void
    {
        throw ValidationException::withMessages([
            "Asset Movement - Baris {$rowNumber}" => $errors,
        ]);
    }
}