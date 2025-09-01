<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleBuildingExport;
use App\Exports\ScheduleExport;
use App\Models\Employeebuild;
use App\Models\ScheduleBuilding;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleBuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Employeebuild $employeebuild)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
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
        $employees = Employeebuild::with(['schedulebuildings' => function ($query) use ($startOfMonth, $endOfMonth) {
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

        return view('building.schedules.index', compact('employees', 'weeks', 'bulan'));
        
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

        return view('building.schedules.index', compact('dates', 'bulan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $start = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $end = $start->copy()->addDays(6); // Senin - Minggu

        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->push($date->copy());
        }

        // $existing = $employee->schedules()->whereBetween('date', [$start, $end])->get()->keyBy('date');
        return view('building.schedules.edit', compact('employee', 'dates', 'existing'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $employee = Employeebuild::findOrFail($id);

        foreach ($request->input('schedulebuildings') as $date => $data) {
            ScheduleBuilding::updateOrCreate(
                ['employeebuild_id' => $employee->id, 'date' => $date],
                ['status' => $data['status'], 'remarks' => $data['remarks'] ?? null]
            );
        }

        $start_date = $request->query('start_date');

        // dd($employee->id);
        // return redirect()->route('schedules.edit.weekly', ['id' => $employee->id, 'start_date' => $start_date,])->with('Success', 'Jadwal berhasil disimpan');
        return redirect()->route('schedulebuilds.index')->with('Success', 'Jadwal berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ScheduleBuilding $scheduleBuilding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $start_date = null)
    {
        
        $employee = Employeebuild::findOrFail($id);
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

        $existing = $employee->schedulebuildings()->whereBetween('date', [$start, $end])->get()->keyBy('date');
        return view('building.schedules.edit', compact('employee', 'dates', 'existing'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScheduleBuilding $scheduleBuilding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScheduleBuilding $scheduleBuilding)
    {
        //
    }

    public function exportPdf(Request $request)
    {
         $bulan = $request->input('bulan', now()->format('Y-m'));

        $schedules = $this->getScheduleData($bulan); // fungsi custom untuk ambil data
        $pdf = Pdf::loadView('building.schedules.exports.schedule-pdf', compact('schedules', 'bulan'));

        return $pdf->download("jadwal-maintenance-$bulan.pdf");
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
        return Excel::download(new ScheduleBuildingExport($bulan), "jadwal-maintenance-$bulan.xlsx");
    }
    public function getScheduleData($bulan)
{
    $startDate = Carbon::parse($bulan)->startOfMonth();
    $endDate = Carbon::parse($bulan)->endOfMonth();

    // Ambil data schedule dan group by employee_id
    $scheduleData = ScheduleBuilding::with('employeebuild')
        ->whereBetween('date', [$startDate, $endDate])
        ->get()
        ->groupBy('employeebuild_id');

    // Ambil employee yang memiliki jadwal
    $employees = Employeebuild::whereIn('id', $scheduleData->keys())->get();

    $weeks = [];
    $current = $startDate->copy()->startOfWeek(Carbon::SATURDAY);

    while ($current->lte($endDate)) {
        $weekStart = $current->copy();
        $weekEnd = $current->copy()->addDays(6);

        $dates = [];
        for ($d = 0; $d < 7; $d++) {
            $date = $weekStart->copy()->addDays($d);
            if ($date->gt($endDate)) break;
            $dates[] = $date->format('Y-m-d');
        }

        $employeeRows = [];

        foreach ($employees as $employee) {
            $days = [];
            $totalWork = 0;
            $totalOff = 0;
            $remarks = '';

            foreach ($dates as $date) {
                $record = $scheduleData[$employee->id]->firstWhere('date', $date);
                if ($record) {
                    $days[] = $record->status;
                    if ($record->status === 'Work') $totalWork++;
                    if ($record->status === 'Off') $totalOff++;
                    if ($record->remarks) $remarks = $record->remarks;
                } else {
                    $days[] = '-';
                }
            }

            $employeeRows[] = [
                'name' => $employee->name,
                'position' => $employee->position,
                'days' => $days,
                'total_work' => $totalWork,
                'total_off' => $totalOff,
                'remarks' => $remarks
            ];
        }

        $weeks[] = [
            'start' => $weekStart->format('d M'),
            'end' => $weekEnd->format('d M'),
            'dates' => $dates,
            'employees' => $employeeRows
        ];

        $current->addWeek();
    }

    return $weeks;
}
}