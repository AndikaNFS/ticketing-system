<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        

        // Ambil input tanggal dari request
        // $startDate = $request->input('start_date');

        // if(!$startDate) {
        //     $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        // }

        // $start = Carbon::parse($startDate)->startOfWeek(Carbon::MONDAY);
        // $end = $start->copy()->addDays(6); // Sampai minggu

        // $endDate = $request->input('end_date');


        // $dates = collect();
        // for ($date = $start->copy(); $date <= $end; $date->addDay()) {
        //     $dates->push($date->copy());
        // }

        $bulan = $request->input('bulan', now()->format('Y-m'));

        $startOfMonth = Carbon::parse($bulan)->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $endOfMonth = Carbon::parse($bulan)->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        // BUat array minggu
        $week = [];
        $weekStart = $startOfMonth->copy();

        while ($weekStart <= $endOfMonth) {
            $weekEnd = $weekStart->copy()->addDay(6);

            $weeks[] = [
                'start' => $weekStart->copy(),
                'end' => $weekEnd->copy(),
                'dates' => collect(),
            ];

            $weekStart = $weekStart->copy()->addWeek();
        }

        // Ambil pegawai dengan jadwal antara awal hingga akhir bulan
        $employees = Employee::with(['schedules' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
        }])->get();

        // Isi tanggal per minggu
        foreach ($weeks as &$week) {
            $dates = collect();
            for ($date = $week['start']->copy(); $date <= $week['end']; $date->addDay()) {
                $dates->push($date->copy());
            }
            $week['dates'] = $dates;
        }

        return view('admin.schedules.index', compact('employees', 'weeks', 'bulan'));
        // return view('admin.schedules.index', compact('dates', 'bulan'));
    }


    public function showMonth(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
        $start = Carbon::parse($bulan)->startOfMonth();
        $end = Carbon::parse($bulan)->endOfMonth();

        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->push([
                'tanggal' => $date->toDateString(),
                'hari' => $date->locale('id')->isoFormat('dddd'),
            ]);
        }

        return view('admin.schedules.index', compact('dates', 'bulan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shedule = Schedule::findOrFail($id);

        return view ('schedules.edit', compact('schedule'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
