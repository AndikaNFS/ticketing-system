<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ticket::select('ticketing', 'problem', 'outlet', 'status', 'it_name', 'start_date', 'date_finish','lama_pengerjaan', 'description', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['Ticketing', 'Problem', 'Outlet', 'Status', 'IT Name', 'Date Start', 'Date Finish', 'Work Duration', 'Description' ,'Tanggal'];
    }
}
