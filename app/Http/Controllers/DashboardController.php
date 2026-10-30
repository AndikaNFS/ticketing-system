<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Outlet;
use Carbon\Carbon;
// use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $statusCounts = Ticket::selectRaw("
            SUM(CASE WHEN status = 'Open' THEN 1 END) as  Open,
            SUM(CASE WHEN status = 'InProgress' THEN 1 END) as  InProgress,
            SUM(CASE WHEN status = 'Done' THEN 1 END) as  Done
       ")->first();

        $ticketsByPIC = Ticket::select('employee_id', DB::raw('COUNT(*) as total'))
                            ->with('employee:id,name')
                            ->groupBy('employee_id')
                            ->get();

        $ticketsByOutlet = Ticket::select('outlet_id', DB::raw('COUNT(*) as total'))
                            ->groupBy('outlet_id')
                            ->get();

        // $monthlyTickets = Ticket::selectRaw("DATE_TRUNC('month', created_at) AS bulan, COUNT(*) AS total")
        //                     ->groupBy('bulan')
        //                     ->orderBy('bulan')
        //                     ->get();

        // $monthlyTickets->map(function ($item) {
        //     return [
        //         'bulan' => \Carbon\Carbon::parse($item['bulan'])->isoFormat('MMM YYYY'),
        //         'total' => $item['total']
        //     ];
        // });

        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            $dateColumn = "DATE_TRUNC('month', created_at)";
        } else {
            $dateColumn = "DATE_FORMAT(created_at, '%Y-%m-01')";
        }

        $tickets = DB::table('tickets')
            ->select(DB::raw("$dateColumn AS bulan"), DB::raw('COUNT(*) AS total'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();


        
        // $monthlyTickets = Ticket::selectRaw("MONTH(created_at) as bulan, COUNT(*) as total")
        //                     ->groupBy('bulan')
        //                     ->get();
        
        // $completionTime = Ticket::selectRaw("(date_finish::date - start_date::date) AS lama")
        //                         ->with('outlet:id,name')
        //                         ->whereNotNull('date_finish')
        //                         ->get();
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            $diffColumn = "(date_finish::date - start_date::date)";
        } else {
            // MySQL / MariaDB
            $diffColumn = "DATEDIFF(date_finish, start_date)";
        }

        $lama = DB::table('tickets')
            ->select(DB::raw("$diffColumn AS lama"))
            ->whereNotNull('date_finish')
            ->get();
        

        // dd([
        //     'status' => $statusCounts->toArray(),
        //     'pic' => $ticketsByPIC->toArray(),
        //     'outlet' => $ticketsByOutlet->toArray(),
        //     'monthly' => $monthlyTickets->toArray(),
            // 'sla' => $completionTime->toArray(),
        // ]);

       


        // $filter = $request->filter;

        // $tickets = Ticket::query();

        // // Filter By Month
        // if ($filter == 'month' && $request->filled('month')) {
        //     $month = $request->month;
        //     $tickets->whereRaw("to_char(created_at, 'YYYY-MM') = ?", [$month]);
        // }

        // // Filter by Week
        // if ($filter == 'week' && $request->filled('week')) {
        //     $week = $request->week;
        //     $year = substr($week, 0, 4);
        //     $weekNumber = substr($week, 6);

        //     $tickets->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$year])
        //             ->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$weekNumber]);
        // }

        $filter = $request->filter;
        $tickets = Ticket::query();

        $driver = DB::getDriverName(); // mysql atau pgsql

        // FILTER BY MONTH
        if ($filter == 'month' && $request->filled('month')) {
            $month = $request->month;

            if ($driver === 'mysql') {
                // MySQL
                $tickets->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            } elseif ($driver === 'pgsql') {
                // PostgreSQL
                $tickets->whereRaw("to_char(created_at, 'YYYY-MM') = ?", [$month]);
            }
        }

        // FILTER BY WEEK
        if ($filter == 'week' && $request->filled('week')) {
            $week = $request->week;       // contoh: 2025-W32
            $year = substr($week, 0, 4);  // 2025
            $weekNumber = substr($week, 6); // 32

            if ($driver === 'mysql') {
                // MySQL (YEARWEEK)
                $tickets->whereRaw("YEAR(created_at) = ?", [$year])
                        ->whereRaw("WEEK(created_at, 1) = ?", [$weekNumber]);
            } elseif ($driver === 'pgsql') {
                // PostgreSQL (EXTRACT)
                $tickets->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$year])
                        ->whereRaw("EXTRACT(WEEK FROM created_at) = ?", [$weekNumber]);
            }
        }


        $ticketData = $tickets->get();

        // Status Count
        $statusCounts = [
            'Open' => $ticketData->where('status', 'Open')->count(),
            'InProgress' => $ticketData->where('status', 'InProgress')->count(),
            'Done' => $ticketData->where('status', 'Done')->count(),
            
        ];

        // PIC Count
        // $ticketsByPIC = $ticketData
        //     ->groupBy('employee_id')
        //     ->map(fn ($row) => [
        //         'employee_id' => $row->first()->employee_id,
        //         'total' => $row->count()      
        //     ])
        //     ->values();
        $ticketsByPIC = $ticketData 
                ->groupBy('employee_id')
                ->map(function ($row) {
                // $employee = \App\Models\Employee::find($row->first()->employee_id);

                    return [
                        'employee_name' => $row->first()->employee->name ?? 'Unknown PIC',
                        'total' => $row->count()
                    ];
                })
                ->values();


        // Outlet
        // $ticketsByOutlet = $ticketData
        //         ->groupBy('outlet_id')
        //         ->map(fn ($row) => [
        //             'outlet_id' => $row->first()->outlet_id,
        //             'total' => $row->count()
        //         ])
        //         ->values();
        $ticketsByOutlet = $ticketData
                ->groupBy('outlet_id')
                ->map(function ($row) {
                    $outlet = \App\Models\Outlet::find($row->first()->outlet_id);
                    
                    return [
                        'outlet_name' => $outlet ? $outlet->name : 'Unknown Outlet',
                        'total' => $row->count()
                    ];
                })
                ->values();
            
        $monthlyTickets = $ticketData
                    ->groupBy(fn ($row) => $row->created_at->format('Y-m'))
                    ->map(fn ($item, $key) => [
                        'bulan' => $key,
                        'total' => $item->count()
                    ])
                    ->values();

        $days = $ticketData->map(fn($row) =>
                    ($row->start_date && $row->date_finish) ? $row->date_finish->diffInDays($row->start_date) : null
        )->filter()->values();
        
        $completionTime = [
            'lama' => $days->count() ? round($days->avg(), 1) : 0
        ];
        // $completionTime = [
        //     'lama' => round($ticketData->avg(fn ($row) => 
        //         $row->date_finish ? $row->date_finish->diffInDays($row->start_date) : 0
        // ), 1)
        // ];

        return view ('dashboard', compact('statusCounts', 'ticketsByPIC', 'monthlyTickets', 'completionTime', 'ticketsByOutlet'));
    }

    // Chart Status
    public function chartStatus(Request $request)
    {
        $range = $request->filter ?? 'weekly';

        $query = Ticket::query();

        if ($range === 'weekly') {
            $query->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]);
        } else {
            $query->whereMonth('created_at', now()->month);
        }

        return response()->json([
            'Open' => (clone $query)->where('status', 'Open')->count(),
            'InProgress' => (clone $query)->where('status', 'InProgress')->count(),
            'Done' => (clone $query)->where('status', 'Done')->count(),
        ]);
    }
    
    // Chart Tiket
    public function chartPIC(Request $request)
    {
        $range = $request->filter ?? 'weekly';

        $query = Ticket::query();

        if ($range === 'weekly') {
            $query->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]);
        } else {
            $query->whereMonth('created_at', now()->month);
        }

        $data = $query
            ->selectRaw('employee_id, COUNT(*) as total')
            ->groupBy('employee_id')
            ->with('employee:id,name')
            // ->selectRaw('it_name, COUNT(*) as total')
            // ->groupBy('it_name')
            // ->with('it_name:id,name')
            ->get();

        return response()->json([
            'labels' => $data->pluck('employee.name'),
            'series' => $data->pluck('total'),
        ]);
    }

    // 3. Chart Outlet
    public function chartOutlet(Request $request)
    {
        $range = $request->filter ?? 'weekly';

        $query = Ticket::query();

        if ($range === 'weekly') {
            $query->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]);
        } else {
            $query->whereMonth('created_at', now()->month);
        }

        $data = $query
            ->selectRaw('outlet_id, COUNT(*) as total')
            ->groupBy('outlet_id')
            ->with('outlet:id,name')
            ->get();

        return response()->json([
            'labels' => $data->pluck('outlet.name'),
            'series' => $data->pluck('total'),
        ]);
    }

    // 4. Chart bulanan
    public function chartMonthly()
    {
        $data = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $data->pluck('month')->map(fn ($m) => Carbon::create()->month($m)->format('M')),
            'series' => $data->pluck('total'),
        ]);
    }

    // 5. Chart SLA
    public function chartSLA()
    {
        $data = Ticket::whereNotNull('date_finish')
            -> selectRaw('id, TIMESTAMPDIFF(HOUR, created_at, date_finish) as hours')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'labels' => $data->pluck('id'),
            'series' => $data->pluck('hours'),
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
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
