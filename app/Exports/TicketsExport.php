<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Ticket::select('ticketing', 'problem', 'outlet', 'status', 'it_name', 'start_date', 'date_finish','lama_pengerjaan', 'description', 'created_at')->get();
    // }

    // public function headings(): array
    // {
    //     return ['Ticketing', 'Problem', 'Outlet', 'Status', 'IT Name', 'Date Start', 'Date Finish', 'Work Duration', 'Description' ,'Tanggal'];
    // }
    protected $tickets;
    public function __construct($tickets) { $this->tickets = $tickets; }

    public function collection()
    {
        // return Building::all();
        // return Building::select('ticketing', 'problem', 'outlet_id','vendor_id','pic_id', 'status', 'start_date', 'date_finish','work_duration', 'description', 'created_at')->get();
        // return Ticket::with(['outlet'])->get();
        { return $this->tickets; }
        

    }

    public function map($ticket): array
    {
        return [
            $ticket->ticketing,
            $ticket->problem,
            $ticket->outlet->name ?? 'N/A',
            $ticket->status,
            $ticket->it_name,
            $ticket->start_date,
            $ticket->finish_date,
            $ticket->lama_pengerjaan,
            $ticket->description,
            $ticket->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Ticketing',
            'Outlet',
            'Problem',
            'Status',
            'IT Name',
            'Start Date',
            'Finish Date',
            'Work Duration',
            'Description',
            'Created At',
        ];
    }

}
