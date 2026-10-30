<?php

namespace App\Exports;

use App\Imports\AssetSheetImport;
use App\Imports\InventorySheetImport;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Outlet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Override;

class InventoryImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows ,WithBatchInserts, WithChunkReading

{
    use SkipsFailures;
    /**
     * Create a new class instance.
     */
    // public function __construct()
    // {
        
    // }

    public function sheets(): array
    {
        return [
        'Inventory' => new InventorySheetImport(),
            'Asset' => new AssetSheetImport(),
        ];
    }

    public function collection(Collection $rows)
    {
        // dd([
        //     'first_row' => $rows->first()?->toArray(),
        // ]);
        foreach ($rows as $row) {
            DB::transaction(function () use ($row) {
                $category = Category::where(
                'name',
                trim($row['category']))->first();

                // $serialNumber = trim($row['asset']);

                $outlet = Outlet::where(
                    'name',
                    trim($row['outlet']))->first();

                $sourceOutletName = trim($row['source_outlet'] ?? '');

                $sourceOutlet = $sourceOutletName !== ''
                    ? Outlet::where('name', $sourceOutletName)->first() : null;

                $isTracked = in_array(
                    strtolower(trim((string) $row['is_tracked'])),
                    ['yes', '1', 'true', 'ya'], true
                );

                $device = trim($row['device']);

                $brand = filled($row['brand'] ?? null) ? trim($row['brand']) : null;

                $placement = filled($row['placement'] ?? null) ? trim($row['placement']) : null;

                

                // Cari inventaris yang sama berdasarkan
                // kategori, outlet tujuan, device, brand, placement
                // Excel yang sama di impor ulang

                $inventoryQuery = Inventory::where(
                    'category_id',
                    $category->id
                ) 
                    ->where('outlet_id', $outlet->id)
                    ->where('device', $device);

                $brand === null
                    ? $inventoryQuery->whereNull('brand')
                    : $inventoryQuery->where('brand', $brand);

                $placement === null
                    ? $inventoryQuery->wherenull('placement')
                    : $inventoryQuery->where('placement', $placement);

                $inventory = $inventoryQuery
                    ->lockForUpdate()
                    ->first();

                $data = [
                    'category_id' => $category->id,
                    // 'asset_id' => filled($row['']),
                    'outlet_id' => $outlet->id,
                    'sources_outlet_id' => $sourceOutlet?->id,
                    'device' => $device,
                    'brand' => $brand,
                    'is_tracked' => $isTracked,
                    'quantity' => (int) $row['quantity'],
                    'placement' => $placement,
                    'entry_date' => filled($row['entry_date'] ?? null) ? $row['entry_date'] : null,
                    'description' => filled($row['description'] ?? null) ? trim($row['description']) : null,
                ];

                if ($inventory) {
                    $inventory->update($data);
                } else {
                    $inventory = Inventory::create($data);
                }

                // Bulk hanya menyimpan quantity pada inventaris.

                if (! $isTracked) {
                    return;
                }

                $existingAssets = Asset::where(
                    'inventory_id',
                    $inventory->id
                )->count();

                $missingAssets = max(
                    0,
                    (int) $inventory->quantity - $existingAssets
                );

                for ($i = 0; $i < $missingAssets; $i++) {
                    Asset::create([
                        'inventory_id' => $inventory->id,
                        'outlet_id' => $inventory->outlet_id,
                        'serial_number' => null,
                        'asset_number' => null,
                        'status' => 'In Use',
                        'placement' => $inventory->placement,
                        'entry_date' => $inventory->entry_date,
                    ]);
                }

            });
        }
    }

    // public function model(array $row)
    // {
    //     $category = Category::where(
    //         'name',
    //         trim($row['category']))->first();

    //     $outlet = Outlet::where(
    //         'name',
    //         trim($row['outlet']))->first();

    //     $sourceOutletName = trim($row['sources_outlet'] ?? '');

    //     $sourceOutlet = $sourceOutletName !== ''
    //         ? Outlet::where('name', $sourceOutletName)->first() : null;


    //     return new Inventory([
    //         'category_id' => $category->id,
    //         'outlet_id' => $outlet->id,
    //         'sources_outlet_id' => $sourceOutlet?->id,
    //         'device' => trim($row['device']),
    //         'brand' => filled($row['brand'] ?? null ) ? trim($row['brand']) : null,
    //         'is_tracked' => in_array(strtolower(trim($row['is_tracked'])),
    //             ['yes', '1', 'true', 'ya'], true),
    //         'quantity' => (int) $row['quantity'],
    //         'placement' => filled($row['placement'] ?? null) ? trim($row['placement']) : null,
    //         'entry_date' => filled($row['entry_date'] ?? null) ? $row['entry_date'] : null,
    //         'description' => filled($row['description'] ?? null) ? trim($row['description']) : null,
    //     ]);
    // }

    public function rules(): array
    {
        return [
            '*.device' => ['required', 'string', 'max:255'],
            '*.brand' => ['nullable', 'string', 'max:255'],
            '*.category' => [
                'required', 
                Rule::exists('categories', 'name'),
            ],
            
            '*.outlet' => [
                'required', 
                Rule::exists('outlets', 'name'),
            ],
            
            '*.source_outlet' => [
                'nullable', 
                Rule::exists('outlets', 'name'),
            ],
            '*.is_tracked' => [
                'required', 
                Rule::in(['Yes', 'No', 'yes', 'no', '1', '0', 'true', 'false', 'Ya', 'ya']),
            ],
            '*.quantity' => ['required', 'integer', 'min:1'],
            '*.placement' => ['nullable', 'string', 'max:255'],
            '*.entry_date' => ['nullable', 'date'],
            '*.description' => ['nullable', 'string'],
            
        ];
    }

    // public function prepareForValidation($data, $index)
    // {
    //     if ($index === 2) {
    //         dd([
    //             'row_index' => $index,
    //             'data_received' => $data,
    //             'device_valie' => $data['device'] ?? 'KEY DEVICE TIDAK DITEMUKAN'
    //         ]);
    //     }
    //     return $data;
    // }

    public function customValidationMessages(): array
    {
        return [
            '*.device.required' => 'Nama device wajib diisi.',
            '*.device.max' => 'Nama device maksimal 255 karakter.',

            '*.category.required' => 'Kategori wajib diisi.',
            '*.category.exists' => 'Kategori tidak ditemukan di database.',

            '*.outlet.required' => 'Outlet wajib diisi.',
            '*.outlet.exists' => 'Outlet tidak ditemukan di database.',

            '*.source_outlet.exists' => 'Source Outlet tidak ditemukan di database.',

            '*.is_tracked.required' => 'Status Is Tracked wajib diisi.',
            '*.is_tracked.in' => 'Is Tracked harus bernilai Yes, No, 1, atau 0.',

            '*.quantity.required' => 'Quantity wajib diisi.',
            '*.quantity.integer' => 'Quantity harus berupa bilangan bulat.',
            '*.quantity.min' => 'Quantity minimal 1.',

            '*.entry_date.date' => 'Entry Date bukan tanggal yang valid.',
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            '*.device' => 'Device',
            '*.brand' => 'Brand',
            '*.category' => 'Category',
            '*.outlet' => 'Outlet',
            '*.source_outlet' => 'Source Outlet',
            '*.is_tracked' => 'Is Tracked',
            '*.quantity' => 'Quantity',
            '*.placement' => 'Placement',
            '*.entry_date' => 'Entry Date',
            '*.description' => 'Description',
        ];
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }


}
