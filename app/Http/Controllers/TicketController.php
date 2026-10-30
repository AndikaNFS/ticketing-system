<?php

namespace App\Http\Controllers;

use App\Exports\TicketsExport;
use App\Models\Employee;
use App\Models\Image;
use App\Models\Outlet;
use App\Models\Ticket;
use App\Services\WhatsappService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
// use PDF;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

// use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $status     = $request->query('status');
    $search     = $request->input('search');
    $startDate  = $request->input('start_date');
    $endDate    = $request->input('end_date');
    $outlet_id  = $request->input('outlet_id');
    $employee_id    = $request->input('employee_id');
    $specialOutlet = Outlet::find(22);
    $user = Auth::user(); // ambil dari user login


    $tickets = Ticket::query();

    // Filter status
    if ($status) {
        $tickets->where('status', $status);
    }

    // Filter outlet
    if ($outlet_id) {
        $tickets->where('outlet_id', $outlet_id);
    }

    // Filter IT Name
    if ($employee_id) {
        $tickets->where('employee_id', $employee_id->name);
    }

    // Filter pencarian bebas
    if ($search) {
        $tickets->where(function ($q) use ($search) {
            $q->where('ticketing', 'like', "%{$search}%")
            //   ->orWhere('employee_id', 'like', "%{$search}%")
              ->orWhere('problem', 'like', "%{$search}%")
              ->orWhereHas('outlet', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('employee', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

        // Filter by date range
    if ($request->filled('start') && $request->filled('end')) {
        $tickets->whereBetween('created_at', [
            $request->start,
            $request->end
        ]);
    }

    // Filter tanggal
    // if ($startDate && $endDate) {
    //     try {
    //         $start = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
    //         $end = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

    //         $tickets->whereBetween('created_at', [$start, $end]);
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Format tanggal tidak valid');
    //     }
    // }

    // Ambil data terakhir setelah semua filter
    $tickets = $tickets->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    // Data tambahan untuk filter dropdown
    $outlets   = Outlet::all();

    return view('tickets.index', compact('tickets', 'status', 'outlets', 'search', 'startDate', 'endDate', 'employee_id', 'outlet_id', 'specialOutlet', 'user'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $specialOutlet = Outlet::find(22);
        $outlets = Outlet::all();
        $user = Auth::user(); // ambil dari user login
        // dd($request->all());
        
        return view('tickets.create', compact('outlets','specialOutlet', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'ticketing' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
            // 'outlet' => 'nullable|string|max:255',
            'outlet_id' => 'required|exists:outlets,id',
            'status' => 'required|in:Open,OnProgress,Done,Cancel',
            'employee_id' => 'nullable|exists:employees,id',
            'date_finish' => 'nullable|string|max:255',
            'start_date' => 'nullable|string|max:255',
            'user' => 'required|string|max:50',
            'lama_pengerjaan' => 'nullable|string|max:225',
            'description' => 'nullable|string|max:225',
            'images.*' => 'file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

         // Generate nomor tiket: "TICK-YYYYMMDD-XXX"
        $latestTicket = Ticket::latest()->first();
        $nextNumber = $latestTicket ? ((int)substr($latestTicket->ticketing, -3)) + 1 : 1;
        $ticketNumber = 'RR-' . date('Ymd') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        // dd($request->all());


        $ticket = Ticket::create([
            'ticketing' => $ticketNumber,
            'problem' => $request->problem,
            // 'outlet' => $request->outlet,
            'outlet_id' => $request->outlet_id,
            'status' => $request->status,
            'user' => $request->user,
            'employee_id' => null,
            'date_finish' => null,
            'start_date' => null,
            'lama_pengerjaan' => null,
            'description' => null,
            'images.*' => null,
            // 'it_name' => $request->it_name,
            // 'date_finish' => $request->date_finish,
            // 'lama_pengerjaan' => $request->lama_pengerjaan,
        ]);

        

        if ($ticket->date_finish) {
            $start = $ticket->created_at;
            $end = $ticket->date_finish;
            $ticket->lama_pengerjaan = $start->diffInDays($end);
            $ticket->save();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path =$file->store('ticket_images', 'public');
                // Image::create([
                //     'ticket_id' => $ticket->id,
                //     'path' => $path,
                // ]);
                $ticket->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('tickets.index')->with('success', 'Data berhasil disimpan!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $ticket = Ticket::findOrFail($id);
        $ticket = Ticket::where('id', $id)->get();
        // $ticket = Ticket::where('id', $id)->first();
        // $ticket = Ticket::findOrFail($id);
        $employees= Employee::where('id', $id)->get();
        $edit = Ticket::with('editor')->findOrFail($id);

        return view('tickets.detail', compact('ticket', 'edit', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $outlets = Outlet::all();
        $employees = Employee::active()->get();
        // $employees = Employee::all()->where('name', '!=', 'All');

        // Cek apakah ini edit pertama kali
        if (!session()->has('edit_step_'.$id)) {
            session(['edit_step_'.$id => 1]); // Set edit pertama
        }

        // $statusOptions = [
        //     'Open' => 'bg-red-500',
        //     'OnProgress' => 'bg-yellow-500',
        //     'Done' => 'bg-green-500',
        //     'Pending' => 'bg-blue-500'
        // ];

        return view('tickets.edit', compact('ticket', 'outlets', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket, $id)
    {
    
        $validated = $request->validate([
            'ticketing' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
            // 'outlet' => 'required|string|max:255',
            'outlet_id' => 'required|exists:outlets,id',
            'employee_id' => 'required|exists:employees,id',
            'status' => 'required|in:Open,InProgress,Done,Cancel',
            // 'employee_id' => $request->employee_id == 'Done' ? 'required|exists:employees,id' : 'required|exists:employees,id',
            'date_finish' => $request->status == 'Done' ? 'required|date' : 'nullable|date',
            'lama_pengerjaan' => $request->lama_pengerjaan == 'Done' ? 'required|string|max:255' : 'nullable|string|max:225',
            'start_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:20480', // max 20MB
        ]);
        // dd($request->all());

        $ticket = Ticket::findOrFail($id);
        // $dateFinish = $request->date_finish ? Carbon::parse($request->date_finish) : null;
        // $lamaPengerjaan = null;
        // $createdAt = Carbon::parse($ticket->created_at);
        $startDate = Carbon::parse($ticket->start_date);

        // Ambil date_finish dari inputan user (form edit)
        $dateFinish = $request->date_finish ? Carbon::parse($request->date_finish) : null;

        if ($dateFinish) {
            $diff = $startDate->diff($dateFinish);
            $lamaPengerjaan = $diff->d . ' hari ' . $diff->h . ' jam ' . $diff->i . ' menit';
        } else {
            $lamaPengerjaan = null;
        }

        $lamaPengerjaan = $dateFinish ? $startDate->diff($dateFinish)->format('%d hari %h jam %i menit') : null; 


        $ticket->update($validated + [
            'ticketing' => $request->ticketing,
            'problem' => $request->problem,
            'outlet_id' => $request->outlet_id,
            'status' => $request->status,
            'employee_id' => $request->employee_id,
            'date_finish' => $dateFinish,
            'start_date' => $request->start_date,
            'lama_pengerjaan' => $lamaPengerjaan,
            'description' => $request->description,
            'edited_by' => auth()->id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images/ticketing', 'public');
                $ticket->images()->create(['path' => $path]);
            }
        }

        $employee = Employee::find($ticket->employee_id);
        $tanggal = Carbon::parse($ticket->start_date)->format('d-m-y') ?? 'No date start available';
        // $tanggal = Carbon::parse($ticket->start_date?->format('d-m-y') ?? 'No date start available');
        
        $message = "
        🎟️ *TICKETING*
        *======================*
        Tanggal : {$tanggal}
        Outlet  : {$ticket->outlet->name}
        Problem : {$ticket->problem}
        Ticket  : {$ticket->ticketing}
        Status  : {$ticket->status}
        Start Date : {$ticket->start_date}
        Finish Date : {$ticket->date_finish}
        Lama Pengerjaan : {$ticket->lama_pengerjaan}
        
        Description : {$ticket->description}
        ";

        WhatsappService::send($employee->phone_number, $message);

        session(['edit_step_'.$id => session('edit_step_'.$id, 1) + 1]);
         
        // Jika statusnya "OnProgress", tetap di halaman edit
        // if ($request->status == 'OnProgress') {
        //     return redirect()->back()->with('success', 'Status updated to OnProgress');
        // }

        return redirect()->route('tickets.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);

        // Hapus file fisik
        Storage::delete('public/' . $image->path);

        // hapus dari database
        $image->delete();

        return back()->with('success', 'Gambar berhasil di hapus');
    }

    private function queryWithFilter(Request $request)
{
    $tickets = Ticket::query();

    if($request->start_date && $request->end_date){
        $tickets->whereBetween('created_at', [
            $request->start_date, $request->end_date
        ]);
    }
    if($request->it_name){
        $tickets->where('it_name', $request->it_name);
    }
    if($request->outlet_id){
        $tickets->where('outlet_id', $request->outlet_id);
    }
    if($request->status){
        $tickets->where('status', $request->status);
    }

    return $tickets->get();
}

    public function exportExcel(Request $request)
    {
        $tickets = Ticket::query();

        if ($request->filled('status')) {
            $tickets->where('status', $request->status);
        }
        if ($request->filled('outlet_id')) {
            $tickets->where('outlet_id', $request->outlet_id);
        }
        if ($request->filled('start') && $request->filled('end')) {
            $tickets->whereBetween('created_at', [$request->start, $request->end]);
        }

        $data = $tickets->get();

        return Excel::download(new TicketsExport($data), 'Ticketing-IT.xlsx');
        // $data = $this->queryWithFilter($request);
        // return Excel::download(new TicketsExport, 'Ticketing-IT.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $tickets = Ticket::query();

        if ($request->filled('status')) {
            $tickets->where('status', $request->status);
        }
        if ($request->filled('outlet_id')) {
            $tickets->where('outlet_id', $request->outlet_id);
        }
        if ($request->filled('start') && $request->filled('end')) {
            $tickets->whereBetween('created_at', [$request->start, $request->end]);
        }

        $data = $tickets->get();

        $pdf = FacadePdf::loadView('tickets.export-pdf', compact('data'));
        return $pdf->download('RR-tickets.pdf');
        // $tickets = Ticket::all();
        // $data = $this->queryWithFilter($request);
        // $pdf = FacadePdf::loadView('tickets.export-pdf', compact('tickets'));
        
        // return $pdf->download('RR-Ticketing.pdf');
    }

    
}
