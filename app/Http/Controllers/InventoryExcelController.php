<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use App\Exports\InventoryTemplateExport;
use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    } catch (\Illuminate\Validation\ValidationException $e) {

        Log::warning('Inventory import validation failed', [
            'errors' => $e->errors(),
        ]);

        return redirect()
            ->route('inventories.index')
            ->withErrors($e->errors())
            ->withInput();

    } catch (\Throwable $e) {

        Log::error('Inventory and Asset import failed', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        report($e);

        return redirect()
            ->route('inventories.index')
            ->with(
                'error',
                'Import gagal: terjadi kesalahan saat memproses data. Silakan periksa Laravel log.'
            );
    }
}

}
