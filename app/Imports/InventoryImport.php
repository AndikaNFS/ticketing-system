<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class InventoryImport implements WithMultipleSheets, SkipsUnknownSheets
{
    public function sheets(): array
    {
        Log::info('InventoryImport: sheets() dipanggil');
        
        return [
            'Worksheet' => new InventorySheetImport(),
            'Asset' => new AssetSheetImport(),
            'Asset Movement' => new AssetMovementSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        Log::warning("Sheet tidak ditemukan: {$sheetName}");
    }
}
