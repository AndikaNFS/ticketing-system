<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use App\Exports\InventoryTemplateExport;
use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class InventoryExcelController extends Controller
{
    public function export()
    {
        return Excel::download(
            new InventoryExport(),
            'it-inventory' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }

    public function template()
    {
        // return Excel::download(
        //     new InventoryExport(),
        //     'it-inventory-template.xlsx'
        // );

        $categories = Category::orderBy('name')
        ->pluck('name')
        ->toArray();

        $outlets = Outlet::orderBy('name')
            ->pluck('name')
            ->toArray();

        return Excel::download(
            new InventoryTemplateExport($categories, $outlets),
            'it-inventory-template.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        $import = new InventoryImport();

        // Excel::import($import, $request->file('file'));

        // $failures = $import->failures();
        // if ($failures->isNotEmpty()) {
        //     dd($failures->map(fn ($failure) => [
        //         'row' => $failure->row(),
        //         'attribute' => $failure->attribute(),
        //         'errors' => $failure->errors(),
        //         'value' => $failure->values(),
        //     ])->all());
        // }

         try {
            DB::transaction(function () use ($request) {
                Excel::import(
                    new InventoryImport(),
                    $request->file('file')
                );
            });
            // DB::transaction(function () use ($request, $import) {
            //     Excel::import($import, $request->file('file'));
            // });

            // dd([
            //     'inventory_rows' => $import->inventoryRows ?? 'not calculated',
            //     'asset_rows' => $import->assetRows ?? 'not calculated',
            //     'database' => config('database.default'),
            // ]);

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Inventory and asset data imported successfully.');

        } catch (ValidationException $e) {
            return redirect()
                ->route('inventories.index')
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('inventories.index')
                ->with('error', 'Import failed. Please check the Excel format and Laravel log.');
        }

        // $failures = collect($import->failures())->map(function ($failure) {
        //     $attribute = $failure->attribute();

        //     // Mengambil nama kolom, termasuk jika atribut memiliki prefix
        //     $parts = explode('.', $attribute);
        //     $column = end($parts);

        //     $columnNames = [
        //         'device' => 'Device',
        //         'brand' => 'Brand',
        //         'serial_number' => 'Serial Number',
        //         'category' => 'Category',
        //         'outlet' => 'Outlet',
        //         'source_outlet_id' => 'Source Outlet',
        //         'is_tracked' => 'Is Tracked',
        //         'quantity' => 'Quantity',
        //         'placement' => 'Placement',
        //         'entry_date' => 'Entry Date',
        //         'description' => 'Description',
        //     ];

        //     $values = $failure->values();

        //     return [
        //         'row' => $failure->row(),
        //         'column' => $columnNames[$column] ?? $column,
        //         'value' => $values[$column] ?? null,
        //         'errors' => $failure->errors(),
        //     ];
        // })->values()->all();

        // if (!empty($failures)) {
        //     return redirect()
        //         ->route('inventories.index')
        //         ->with('import_failures', $failures)
        //         ->with('warning', 'Import completed, but some rows failed validation.');
        // }

        // return redirect()->route('inventories.index')->with('success', 'Inventory data imported successfully.');
    }
}
