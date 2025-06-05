<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleExport;
use App\Models\Employee;
use App\Models\Schedule;
use App\Services\HolidayService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Employee $employee)
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
        // dd($employee->id);
        
        $bulan = $request->input('bulan', now()->format('Y-m'));
        
        // $year = Carbon::parse($bulan)->year;
        // $liburNasional = HolidayService::getIndonesianHolidays($year);

        $startOfMonth = Carbon::parse($bulan)->startOfMonth()->startOfWeek(Carbon::SATURDAY);
        $endOfMonth = Carbon::parse($bulan)->endOfMonth()->endOfWeek(Carbon::FRIDAY);

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
                // $isLibur = in_array($date->format('Y-m-d'), $liburNasional);

                // Menyisipkan informasi apakah tanggal tersebut libur nasional
                // $date->is_libur_nasional = $isLibur;
                // $dates->push($date->copy());
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

        // $employee = Employee::findOrFail($id);
        $start = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $end = $start->copy()->addDays(6); // Senin - Minggu

        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->push($date->copy());
        }

        // $existing = $employee->schedules()->whereBetween('date', [$start, $end])->get()->keyBy('date');
        return view('admin.schedules.edit', compact('employee', 'dates', 'existing'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        foreach ($request->input('schedule') as $date => $data) {
            Schedule::updateOrCreate(
                ['employee_id' => $employee->id, 'date' => $date],
                ['status' => $data['status'], 'remarks' => $data['remarks'] ?? null]
            );
        }

        $start_date = $request->query('start_date');

        // dd($employee->id);
        // return redirect()->route('schedules.edit.weekly', ['id' => $employee->id, 'start_date' => $start_date,])->with('Success', 'Jadwal berhasil disimpan');
        return redirect()->route('schedules.index')->with('Success', 'Jadwal berhasil disimpan');
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
    public function edit($id, $start_date = null)
    {
        
        // $employeeModel = \App\Models\Employee::find($employee);
    // dd($employee, $employeeModel);
    // dd($employee);

        $employee = Employee::findOrFail($id);
        // $start = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        // $end = $start->copy()->addDays(6); // Senin - Minggu
        $start = $start_date
            ? Carbon::parse($start_date)->startOfWeek(Carbon::SATURDAY)
            : Carbon::now()->startOfWeek(Carbon::SATURDAY);
        
        $end = $start->copy()->addDays(6);

        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->push($date->copy());
        }

        $existing = $employee->schedules()->whereBetween('date', [$start, $end])->get()->keyBy('date');
        return view('admin.schedules.edit', compact('employee', 'dates', 'existing'));
        // return view('admin.schedules.edit', compact('employee'));
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

    public function exportPdf(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
        $startOfMonth = Carbon::parse($bulan)->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $endOfMonth = Carbon::parse($bulan)->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        // sama seperti index() sebelumnya
        $weeks = [];
        $weekStart = $startOfMonth->copy();
        while ($weekStart <= $endOfMonth) {
            $weekEnd = $weekStart->copy()->addDays(6);
            $weeks[] = [
                'start' => $weekStart->copy(),
                'end' => $weekEnd->copy(),
                'dates' => collect(),
            ];
            $weekStart = $weekStart->copy()->addWeek();
        }

        foreach ($weeks as &$week) {
            $dates = collect();
            for ($date = $week['start']->copy(); $date <= $week['end']; $date->addDay()) {
                $dates->push($date->copy());
            }
            $week['dates'] = $dates;
        }

        $employees = Employee::with(['schedules' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
        }])->get();

        $pdf = Pdf::loadView('schedules.export-pdf', compact('employees', 'weeks', 'bulan'))->setPaper('A4', 'landscape');
        return $pdf->download("jadwal-{$bulan}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
        return Excel::download(new ScheduleExport($bulan), "jadwal-{$bulan}.xlsx");
    }
}
