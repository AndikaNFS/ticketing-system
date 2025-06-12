<?php

namespace App\Http\Controllers;

use App\Exports\DailyReportsExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\DailyReport;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DailyReportController extends Controller
{
    use AuthorizesRequests;

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DailyReport::where('user_id', Auth::id());
        // $outlets = Outlet::all();

        // Filter by month and year
        if ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('date', $request->month)
              ->whereYear('date', $request->year);
    }

    $reports = $query->orderBy('date', 'desc')->get();

        // $reports = DailyReport::where('user_id', Auth::id())
        //     ->orderBy('date', 'desc')
        //     ->get();

        return view('reports.index',[
            'reports' => $reports,
            'selectedMonth' => $request->month,
            'selectedYear' => $request->year,
            // 'outlets' => $outlets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $outlets = Outlet::all();
        return view('reports.create', compact ('outlets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'prev_work' => 'nullable|string',
            'today_work' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:selesai,belum,libur',
        ]);

        DailyReport::create([
            'user_id' => auth()->id(),
            // 'outlet_id' => $request->outlet_id,
            'date' => $request->date,
            'prev_work' => $request->prev_work,
            'today_work' => $request->today_work,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil di simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyReport $dailyReport)
    {
        $this->authorize('view', $dailyReport);

        return view('reports.show', compact('dailyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyReport $dailyReport)
    {
        dd(auth()->id(), $dailyReport->user_id, auth()->user());
        $this->authorize('update', $dailyReport);

        return view('reports.edit', compact('dailyReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyReport $dailyReport)
    {
        $this->authorize('update', $dailyReport);

        $request->validate([
            'date' => 'required|date',
            'outlet_id' => 'nullable|string',
            'prev_work' => 'nullable|string',
            'today_work' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:selesai,belum,libur',
        ]);

        $dailyReport->update($request->only(['date', 'prev_work', 'today_work', 'notes', 'status']));

        // return $user->id === $dailyReport->user_id;
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyReport $dailyReport)
    {
        $this->authorize('delete', $dailyReport);
        $dailyReport->delete();

        return redirect()->route('reports.index')->with('success', 'Laporam berhasil dihapus');
    }

    public function exportExcel(Request $request)
{
    $month = $request->month;
    $year = $request->year;
    $userId = auth()->id();

    return Excel::download(new DailyReportsExport($month, $year, $userId), 'laporan-harian.xlsx');
}
}
