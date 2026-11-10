<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetOutletExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $outletId;
    protected $filters;

    public function __construct($outletId, array $filters = [])
    {
        $this->outletId = $outletId;
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Asset::query()
            ->with(['inventory.category', 'outlet'])
            ->where('outlet_id', $this->outletId);

        if (!empty($this->filters['category_id'])) {
            $query->whereHas('inventory', function ($q) {
                $q->where('category_id', $this->filters['category_id']);
            });
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('asset_number', 'like', "%{$search}%")
                    ->orWhereHas('inventory', function ($inventoryQuery) use ($search) {
                        $inventoryQuery
                            ->where('device', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%")
                            ->orWhere('type', 'like', "%{$search}%");
                    });
            });
        }

        return $query->orderBy('asset_number');
    }

    public function headings(): array
    {
        return [
            'Asset Number',
            'Device',
            'Brand',
            'Type',
            'Serial Number',
            'Category',
            'Outlet',
            'Status',
            'Placement',
            'Entry Date',
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->asset_number,
            $asset->inventory?->device,
            $asset->inventory?->brand,
            $asset->inventory?->type,
            $asset->serial_number,
            $asset->inventory?->category?->name,
            $asset->outlet?->name,
            $asset->status,
            $asset->placement,
            $asset->entry_date?->format('Y-m-d'),
        ];
    }
}
