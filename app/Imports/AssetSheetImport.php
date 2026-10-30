<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AssetSheetImport implements ToCollection, WithHeadingRow, WithTitle
{
    /**
     * Create a new class instance.
     */
    public function title(): string
    {
        return 'Asset';
    }

    public function collection(Collection $rows)
    {
        // Log::info('AssetSheetImport: collection dipanggil', [
        //     'jumlah_baris' => $rows->count(),
        // ]);
        
        foreach ($rows as $index => $row) {
            $row = $row->toArray();

            Log::info('AssetSheetImport: data baris Excel', [
                'row' => $index + 2,
                'inventory_ref' => $row['inventory_ref'] ?? null,
                'serial_number' => $row['serial_number'] ?? null,
                'asset_number' => $row['asset_number'] ?? null,
                'status' => $row['status'] ?? null,
            ]);

            if (
                empty($row['inventory_ref']) &&
                empty($row['serial_number']) &&
                empty($row['asset_number'])
            ) {
                continue;
            }

            // Konversiu validasi yang sudah ada disini
            foreach (['serial_number', 'asset_number'] as $field) {
                if (isset($row[$field]) && $row[$field] !== '') {
                    $row[$field] = (string) $row[$field];
                }
            }

            $hasInventoryData = collect($row)
                ->except(['inventory_ref'])
                ->contains(
                    fn ($value) => $value !== null && trim((string) $value) !== ''
                );
            
            if (!$hasInventoryData) {
                continue;
            }

            $rowNumber = $index + 2;

            if (collect($row)->every(
                fn ($value) => $value === null || trim((string) $value) === ''
            )) {
                continue;
            }

            $rowNumber = $index + 2;

            $validator = Validator::make($row, [
                'inventory_ref' => ['required', 'string'],
                'serial_number' => ['nullable', 'string', 'max:255'],
                'asset_number'  => ['nullable', 'string', 'max:255'],
                'status'        => ['required', 'in:Available,In Use,Repair,Lost,Disposed'],
                'placement'     => ['nullable', 'string', 'max:255'],
                'entry_date'    => ['nullable'],
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'file' => [
                        "Sheet Asset, baris {$rowNumber}: " .
                        implode(' ', $validator->errors()->all()),
                    ],
                ]);
            }

            $ref = trim($row['inventory_ref']);

            $inventory = Inventory::where('import_ref', $ref)->first();

            if (!$inventory) {
                throw ValidationException::withMessages([
                    'file' => [
                        "Sheet Asset, baris {$rowNumber}: Inventory Ref '{$ref}' tidak ditemukan di sheet Inventory.",
                    ],
                ]);
            }

            if (!$inventory->is_tracked) {
                throw ValidationException::withMessages([
                    'file' => [
                        "Sheet Asset, baris {$rowNumber}: inventaris '{$inventory->device}' tidak menggunakan pelacakan per aset (Is Tracked = No).",
                    ],
                ]);
            }

            $serialNumber = $this->nullableString($row['serial_number'] ?? null);
            $assetNumber = $this->nullableString($row['asset_number'] ?? null);
            $assetDate = filled($row['entry_date'] ?? null)
                ? $this->parseDate($row['entry_date'])
                : $inventory->entry_date;

            // Generate otomatis jika Asset Number kosong
            if ($assetNumber === null) {
                $assetNumber = $this->generateAssetNumber(
                    $assetDate,
                    $inventory
                );
            }

            if ($serialNumber !== null &&
                Asset::where('serial_number', $serialNumber)->exists()) {
                throw ValidationException::withMessages([
                    'file' => ["Serial Number '{$serialNumber}' sudah terdaftar (baris {$rowNumber})."],
                ]);
            }

            if ($assetNumber !== null &&
                Asset::where('asset_number', $assetNumber)->exists()) {
                throw ValidationException::withMessages([
                    'file' => ["Asset Number '{$assetNumber}' sudah terdaftar (baris {$rowNumber})."],
                ]);
            }

            $assetDate = filled($row['entry_date'] ?? null)
                ? $this->parseDate($row['entry_date'])
                : $inventory->entry_date;

            Asset::create([
                'inventory_id'  => $inventory->id,
                'outlet_id'     => $inventory->outlet_id,
                'serial_number' => $serialNumber,
                'asset_number'  => $assetNumber,
                'status'        => trim($row['status']),
                'placement'     => $this->nullableString($row['placement'] ?? null)
                    ?? $inventory->placement,
                'entry_date'    => $assetDate,
            ]);
        }
    }

    private function generateAssetNumber(
        $assetDate,
        Inventory $inventory
    ): string {
        $dateCode = Carbon::parse($assetDate)->format('ymd');

        $categoryCode = str_pad(
            (string) $inventory->category_id,
            2,
            '0',
            STR_PAD_LEFT
        );

        $outletCode = str_pad(
            (string) $inventory->outlet_id,
            2,
            '0',
            STR_PAD_LEFT
        );

        $prefix = "{$dateCode}{$categoryCode}{$outletCode}";

        $lastAssetNumber = Asset::where(
            'asset_number',
            'like',
            "{$prefix}%"
        )
            ->orderByDesc('asset_number')
            ->value('asset_number');

        $lastSequence = $lastAssetNumber
            ? (int) substr($lastAssetNumber, -3)
            : 0;

        $nextSequence = $lastSequence + 1;

        if ($nextSequence > 999) {
            throw ValidationException::withMessages([
                'file' => [
                    "Nomor urut Asset Number untuk prefix {$prefix} sudah mencapai batas 999.",
                ],
            ]);
        }

        return sprintf(
            '%s%03d',
            $prefix,
            $nextSequence
        );
    }

    private function nullableString($value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        return trim((string) $value);
    }

    private function parseDate($value): string
    {
        try {
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject((float) $value)
                    ->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'file' => ["Format Entry Date tidak valid: {$value}."],
            ]);
        }
    }
}
