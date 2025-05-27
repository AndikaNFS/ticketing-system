<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{
    protected $bulan;

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     $start = Carbon::parse($this->bulan)->startOfMonth()->startOfWeek(Carbon::MONDAY);
    //     $end = Carbon::parse($this->bulan)->endOfMonth()->endOfWeek(Carbon::SUNDAY);

    //     $weeks = [];
    //     $weekStart = $start->copy();
    //     while ($weekStart <= $end) {
    //         $weekEnd = $weekStart->copy()->addDays(6);
    //         $dates = collect();
    //         for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
    //             $dates->push($date->copy());
    //         }

    //         $weeks[] = [
    //             'start' => $weekStart->copy(),
    //             'end' => $weekEnd->copy(),
    //             'dates' => $dates,
    //         ];

    //         $weekStart = $weekStart->copy()->addWeek();
    //     }

    //     $employees = Employee::with(['schedules' => function ($q) use ($start, $end) {
    //         $q->whereBetween('date', [$start, $end]);
    //     }])->get();

    //     return view('schedules.export-excel', [
    //         'weeks' => $weeks,
    //         'employees' => $employees,
    //         'bulan' => $this->bulan,
    //     ]);
    // }

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    // public function view(): View
    // { 
    //     $start = Carbon::parse($this->bulan)->startOfMonth()->startOfWeek(Carbon::MONDAY);
    //     $end = Carbon::parse($this->bulan)->endOfWeek(Carbon::SUNDAY);

    //     $week = [];
    //     $weekStart = $start->copy();
    //     while ($weekStart <= $end) {
    //         $weekEnd = $weekStart->copy()->addDays(6);
    //         $dates = collect();
    //         for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDays())
    //             $dates->push($date->copy());
    //     }

    //     $weeks[] = [
    //         'start' => $weekStart->copy(),
    //         'end' => $weekEnd->copy(),
    //         'dates' => $dates,
    //     ];

    //     $weekStart = $weekStart->copy()->addWeek();
    // }

    // $employees = Employee::with(['schedules' => function ($q) use ($start, $end) {
    //         $q->whereBetween('date', [$start, $end]);
    //     }])->get();



    // return view('schedules.export-excel', ['weeks' => $weeks, 'employees' => $employees, 'bulan' => $this->bulan]);
     public function view(): View
    {
        $start = Carbon::parse($this->bulan)->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $end = Carbon::parse($this->bulan)->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $weeks = [];
        $weekStart = $start->copy();
        while ($weekStart <= $end) {
            $weekEnd = $weekStart->copy()->addDays(6);
            $dates = collect();
            for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
                $dates->push($date->copy());
            }

            $weeks[] = [
                'start' => $weekStart->copy(),
                'end' => $weekEnd->copy(),
                'dates' => $dates,
            ];

            $weekStart = $weekStart->copy()->addWeek();
        }

        $employees = Employee::with(['schedules' => function ($q) use ($start, $end) {
            $q->whereBetween('date', [$start, $end]);
        }])->get();

        return view('schedules.export-excel', [
            'weeks' => $weeks,
            'employees' => $employees,
            'bulan' => $this->bulan,
        ]);
    }
}

