<?php

namespace App\Exports;

use App\Models\Visit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// class TicketsExport implements FromCollection, WithHeadings, WithMapping
class VisitExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $visits;
    public function __construct($visits) { $this->visits = $visits; }

    public function collection()
    {
        // return Visit::all();
        { return $this->visits; }

    }

    public function map($visit): array
    {
        return [
            $visit->employee->name ?? '-',
            $visit->tanggal_visit,
            $visit->outlet->name ?? 'N/A',
            $visit->ticket->ticketing ?? 'N/A',
            $visit->description,
            $visit->status,
            $visit->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'IT Name',
            'Visit Date',
            'Outlet',
            'Ticket',
            'Job Desk',
            'Status',
            'Created At',
        ];
    }
}
