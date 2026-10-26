<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Outlet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;

class InventorySheetImport implements ToCollection, WithHeadingRow, WithTitle
{
    /**
     * Create a new class instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    public function title(): string
    {
        return 'Inventory';
    }

    public function collection(Collection $rows)
    {
        Log::info('InventorySheetImport: collection dipanggil', [
            'jumlah_baris' => $rows->count(),
        ]);

        foreach ($rows as $index => $row) {
            $row = $row->toArray();

            // if (collect($row)->every(
            //     fn ($value) => $value === null || trim((string) $value) === ''
            // )) {
            //     continue;
            // }

            $hasInventoryData = collect($row)
                ->except(['inventory_ref'])
                ->contains(fn ($value) => $value !== null && trim((string) $value) !== '' );

            if (!$hasInventoryData) {
                continue;
            }

            // $rowNumber = $index + 2;

            $rowNumber = $index + 2;

            $validator = Validator::make($row, [
                'inventory_ref' => ['required', 'string', 'max:100'],
                'device'        => ['required', 'string', 'max:255'],
                'brand'         => ['nullable', 'string', 'max:255'],
                'type'         => ['nullable', 'string', 'max:255'],
                'category'      => ['required', 'string'],
                'outlet'        => ['required', 'string'],
                'source_outlet' => ['nullable', 'string'],
                'is_tracked'    => ['required', 'in:Yes,No'],
                'quantity'      => ['required', 'integer', 'min:0'],
                'placement'     => ['nullable', 'string', 'max:255'],
                'entry_date'    => ['nullable'],
                'description'   => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'file' => [
                        "Sheet Inventory, baris {$rowNumber}: " .
                        implode(' ', $validator->errors()->all()),
                    ],
                ]);
            }

            $category = Category::where('name', trim($row['category']))->first();
            $outlet = Outlet::where('name', trim($row['outlet']))->first();

            $sourceOutletName = trim((string) ($row['source_outlet'] ?? ''));
            $sourceOutlet = $sourceOutletName !== ''
                ? Outlet::where('name', $sourceOutletName)->first()
                : null;

            if (!$category) {
                throw ValidationException::withMessages([
                    'file' => ["Kategori '{$row['category']}' tidak ditemukan pada baris {$rowNumber}."],
                ]);
            }

            if (!$outlet) {
                throw ValidationException::withMessages([
                    'file' => ["Outlet '{$row['outlet']}' tidak ditemukan pada baris {$rowNumber}."],
                ]);
            }

            if ($sourceOutletName !== '' && !$sourceOutlet) {
                throw ValidationException::withMessages([
                    'file' => ["Source Outlet '{$sourceOutletName}' tidak ditemukan pada baris {$rowNumber}."],
                ]);
            }

            $ref = trim($row['inventory_ref']);

            $existing = Inventory::where('import_ref', $ref)->first();

            $inventory = Inventory::updateOrCreate(
                ['import_ref' => $ref],
                [
                    'category_id'       => $category->id,
                    'outlet_id'         => $outlet->id,
                    'sources_outlet_id' => $sourceOutlet?->id,
                    'device'            => trim($row['device']),
                    'type'            => trim($row['type']),
                    'brand'             => filled($row['brand'] ?? null)
                        ? trim($row['brand']) : null,
                    'is_tracked'        => $row['is_tracked'] === 'Yes',
                    'quantity'          => (int) $row['quantity'],
                    'placement'         => filled($row['placement'] ?? null)
                        ? trim($row['placement']) : null,
                    'entry_date'        => filled($row['entry_date'] ?? null)
                        ? $this->parseDate($row['entry_date']) : null,
                    'description'       => $row['description'] ?? null,
                ]
            );

        }
    }

    private function parseDate($value): string
    {
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                (float) $value
            )->format('Y-m-d');
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'file' => ["Format Entry Date tidak valid: {$value}."],
            ]);
        }
    }
}
