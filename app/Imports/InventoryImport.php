<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InventoryImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        Log::info('InventoryImport: sheets() dipanggil');
        
        return [
            'Worksheet' => new InventorySheetImport(),
            'Worksheet 1' => new AssetSheetImport(),
        ];
    }
}
