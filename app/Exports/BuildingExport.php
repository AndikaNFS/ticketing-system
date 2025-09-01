<?php

namespace App\Exports;

use App\Models\Building;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuildingExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Building::all();
        // return Building::select('ticketing', 'problem', 'outlet_id','vendor_id','pic_id', 'status', 'start_date', 'date_finish','work_duration', 'description', 'created_at')->get();
        return Building::with(['outlet', 'vendor', 'pic'])->get();

    }

    public function map($building): array
    {
        return [
            $building->ticketing,
            $building->problem,
            $building->outlet->name ?? 'N/A',
            $building->vendor->name ?? 'N/A',
            $building->pic->name ?? 'N/A',
            $building->status,
            $building->start_date,
            $building->finish_date,
            $building->work_duration,
            $building->description,
            $building->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Ticketing',
            'Outlet',
            'Problem',
            'Status',
            'Vendor',
            'PIC',
            'Start Date',
            'Finish Date',
            'Work Duration',
            'Description',
            'Created At',
        ];
    }


}
