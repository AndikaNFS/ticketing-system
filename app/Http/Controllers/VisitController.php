<?php

namespace App\Http\Controllers;

use App\Exports\VisitExport;
use App\Models\Employee;
use App\Models\Image;
use App\Models\ImageVisit;
use App\Models\Outlet;
use App\Models\Ticket;
use App\Models\Visit;
use App\Services\WhatsappService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $visits = Visit::all();
        $status     = $request->query('status');
        $search     = $request->input('search');
        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');
        $outlet_id  = $request->input('outlet_id');
        $employee_id    = $request->input('employee_id');
        $specialOutlet = Outlet::find(22);
        $tickets = Ticket::orderBy('created_at', 'desc')->get();


        

        $visits = Visit::query();


        // Filter status
        if ($status) {
            $visits->where('status', $status);
        }

        // Filter outlet
        if ($outlet_id) {
            $visits->where('outlet_id', $outlet_id);
        }

        // Filter IT Name
        if ($employee_id) {
            $visits->where('employee_id', $employee_id);
        }
        
        // $search = $request->input('search');
        if ($search) {
            $visits = Visit::with(['outlet', 'ticket'])
                ->when($search, function ($query) use ($search) {
                    $query->where('employee_id', 'like', '%' . $search . '%')
                            ->orWhereHas('ticket', function ($q) use ($search) {
                                $q->where('ticketing', 'like', '%' . $search . '%')
                                    ->orWhere('it_name', 'like', '%' . $search . '%')
                                    ->orWhere('problem', 'like', '%' . $search . '%');
                            });
                });
        }
        // ->orderBy('tanggal_visit', 'desc')
        // ->paginate(10);

        // Filter by date range
    if ($request->filled('start') && $request->filled('end')) {
        $visits->whereBetween('tanggal_visit', [
            $request->start,
            $request->end
        ]);
    }
    // Ambil data terakhir setelah semua filter
    $visits = $visits->orderBy('tanggal_visit', 'desc')->paginate(10)->withQueryString();

    // Data tambahan untuk filter dropdown
    $outlets   = Outlet::all();
    // $employees = Employee::all();
    $employees = Employee::active()
                ->where('name', '!=', 'All')
                ->orderBy('name')
                ->get();
    // $employees = Employee::where('is_active', true)->get();



        return view('visits.index', compact('visits', 'search', 'outlets', 'employees', 'search', 'startDate', 'endDate', 'outlet_id', 'specialOutlet', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        $outlets = Outlet::all();
        $employees = Employee::where('name', '!=', 'All')->get();
        $specialOutlet = Outlet::find(22);
        $employees = Employee::active()
                ->where('name', '!=', 'All')
                ->orderBy('name')
                ->get();
        return view('visits.create', compact('tickets', 'outlets', 'specialOutlet', 'employees'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pic' => 'nullable|string|max:255',
            'employee_id' => 'required|string|max:255',
            'tanggal_visit' => 'required|string|max:255',
            'outlet_id' => 'required|string|max:255',
            'ticket_id' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress,Open',
            // 'images.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $visit = Visit::create([
            'pic' => $request->pic,
            'employee_id' => $request->employee_id,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'ticket_id' => $request->ticket_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        $employee = Employee::find($visit->employee_id);
        // $outlet = Outlet::find($visit->outlet_id);
        $tanggal = Carbon::parse($visit->tanggal_visit)->format('d-m-y');
        $jam = Carbon::parse($visit->tanggal_visit)->format('H:i');

        $ticketNumber = $visit->ticket?->ticketing ?? 'Tidak Ada';

        $message = "
        📅 *JADWAL VISIT*
        *======================*
        Tanggal : {$tanggal}
        Jam : {$jam}
        Outlet  : {$visit->outlet->name}
        Ticket  : {$ticketNumber}
        Status  : {$visit->status}
        Job Desk : {$visit->description}
        ";

        WhatsappService::send($employee->phone_number, $message);

        

        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $file) {
        //         $path =$file->store('visit_images', 'public');
                // Image::create([
                //     'ticket_id' => $ticket->id,
                //     'path' => $path,
                // ]);
        //         $visit->images()->create([
        //             'path' => $path,
        //         ]);
        //     }
        // }

        return redirect()->route('visits.index')->with('success', 'Data berhasil di simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $visits = Visit::where('id', $id)->get();

        return view('visits.detail', compact('visits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $visits = Visit::findOrFail($id);
        $outlets = Outlet::all();
        $employees = Employee::active()->where('name', '!=', 'All');
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        $specialOutlet = Outlet::find(22);

         // Cek apakah ini edit pertama kali
        if (!session()->has('edit_step_'.$id)) {
            session(['edit_step_'.$id => 1]); // Set edit pertama
        }


        return view('visits.edit', compact('visits', 'outlets', 'tickets', 'specialOutlet', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit, $id)
    {
        $request->validate([
            'pic' => 'nullable|string|max:255',
            'employee_id' => 'required|exists:employees,id',
            'tanggal_visit' => 'required|date',
            'outlet_id' => 'required|exists:outlets,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress,Open',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:20480',

        ]);
    
        $visit = Visit::findOrFail($id);
        $visit->update([
            'pic' => $request->pic,
            'employee_id' => $request->employee_id,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'ticket_id' => $request->ticket_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images/visit', 'public');
                $visit->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('visits.index')->with('success', 'Data berhasil di simpan');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }

    public function destroyImage($id)
    {
        $image = ImageVisit::findOrFail($id);

        // Hapus file fisik
        Storage::delete('public/' . $image->path);

        // hapus dari database
        $image->delete();

        return back()->with('success', 'Gambar berhasil di hapus');
    }

    public function exportExcel(Request $request)
    {
        $visits = Visit::query();

        if ($request->filled('status')) {
            $visits->where('status', $request->status);
        }
        if ($request->filled('outlet_id')) {
            $visits->where('outlet_id', $request->outlet_id);
        }
        if ($request->filled('start') && $request->filled('end')) {
            $visits->whereBetween('tanggal_visit', [$request->start, $request->end]);
        }

        $data = $visits->get();

        return Excel::download(new VisitExport($data), 'Visit-IT.xlsx');
        // $data = $this->queryWithFilter($request);
        // return Excel::download(new TicketsExport, 'Ticketing-IT.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $visits = Visit::query();

        if ($request->filled('status')) {
            $visits->where('status', $request->status);
        }
        if ($request->filled('outlet_id')) {
            $visits->where('outlet_id', $request->outlet_id);
        }
        if ($request->filled('start') && $request->filled('end')) {
            $visits->whereBetween('tanggal_visit', [$request->start, $request->end]);
        }

        $data = $visits->get();

        $pdf = Pdf::loadView('visits.export-pdf', compact('data'));
        return $pdf->download('RR-Visits.pdf');
        // $tickets = Ticket::all();
        // $data = $this->queryWithFilter($request);
        // $pdf = FacadePdf::loadView('tickets.export-pdf', compact('tickets'));
        
        // return $pdf->download('RR-Ticketing.pdf');
    }

    public function testWA()
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => env('WA_TOKEN')
            ])
            ->post('https://api.fonnte.com/send', [
                'target' => '6281285643784',
                'message' => 'Test Laravel WA'
            ]);
        // $response = WhatsappService::send(
        //     '6281285643784',
        //     'Test WA dari RRQonnect',
        // );

        dd($response->json());

        // if ($response->successful()) {
        //     return "WA Berhasil dikirim";
        // }

        return "WA Gagal";
    }

    

}
