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


         try {
            DB::transaction(function () use ($request) {
                Excel::import(
                    new InventoryImport(),
                    $request->file('file')
                );
            });

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
    }
}
