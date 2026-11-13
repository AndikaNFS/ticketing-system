<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Create a new class instance.
     */
    // public function __construct()
    // {
        
    // }
    
    public function query()
    {
        return Inventory::query()
            ->with(['category', 'outlet', 'sourceOutlet'])
            ->withCount('assets')
            ->orderBy('id');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Device',
            'Brand',
            'Type',
            'Category',
            'Outlet',
            'Source Outlet',
            'Is Tracked',
            'Quantity',
            // 'Asset Count',
            'Placement',
            'Entry Date',
            'Description',
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->id,
            $inventory->device,
            $inventory->brand,
            $inventory->type,
            $inventory->category?->name,
            $inventory->outlet?->name,
            $inventory->sourceOutlet?->name,
            $inventory->is_tracked ? 'Yes' : 'No',
            $inventory->quantity,
            // $inventory->assets_count,
            $inventory->placement,
            $inventory->entry_date?->format('Y-m-d'),
            $inventory->description,
        ];
    }
}
