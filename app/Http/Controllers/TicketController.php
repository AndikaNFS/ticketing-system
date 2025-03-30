<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
// use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status'); //Ambil filter status dari query string
        $tickets = Ticket::filterStatus($status);
        $search = $request->input('search');

        // $tickets = Ticket::All();
        $tickets = Ticket::when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('ticketing', 'like', "%{$search}%")
                  ->orWhere('problem', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // $tickets = Ticket::where('ticketing', 'like', "%{$search}%")
        //     ->orWhere('problem', 'like', "%{$search}%")
        //     // ->orWhereHas('outlet', function ($query) use ($search) {
        //     //     $query->where('it_name', 'like', "%{$search}%");
        //     // })
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);

        return view('dashboard', compact('tickets', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'ticketing' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
            'outlet' => 'required|string|max:255',
            'status' => 'required|in:Open,OnProgress,Done,Cancel',
            'it_name' => 'required|string|max:255',
            'date_finish' => 'required|string|max:255',
            'lama_pengerjaan' => 'nullable|string|max:225',
        ]);

         // Generate nomor tiket: "TICK-YYYYMMDD-XXX"
        $latestTicket = Ticket::latest()->first();
        $nextNumber = $latestTicket ? ((int)substr($latestTicket->ticketing, -3)) + 1 : 1;
        $ticketNumber = 'RR-' . date('Ymd') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        // dd($request->all());


        Ticket::create([
            'ticketing' => $ticketNumber,
            'problem' => $request->problem,
            'outlet' => $request->outlet,
            'status' => $request->status,
            'it_name' => $request->it_name,
            'date_finish' => $request->date_finish,
            'lama_pengerjaan' => $request->lama_pengerjaan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

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

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket, $id)
    {
    
        $request->validate([
            'ticketing' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
            'outlet' => 'required|string|max:255',
            'status' => 'required|in:Open,OnProgress,Done,Cancel',
            'it_name' => $request->it_name == 'Done' ? 'required|string|max:255' : 'required|string|max:255',
            'date_finish' => $request->status == 'Done' ? 'required|date' : 'nullable|date',
            'lama_pengerjaan' => $request->it_name == 'Done' ? 'required|string|max:255' : 'nullable|string|max:225',
        ]);
        // dd($request->all());

        $ticket = Ticket::findOrFail($id);
        // $dateFinish = $request->date_finish ? Carbon::parse($request->date_finish) : null;
        // $lamaPengerjaan = null;
        $createdAt = Carbon::parse($ticket->created_at);

        // Jika status "Done", otomatis set date_finish ke sekarang
        if ($request->status == "Done") {
            $dateFinish = Carbon::now();
        } else {
            $dateFinish = $request->date_finish ? Carbon::parse($request->date_finish) : null;
        }
        // if ($request->status == "Done") {
        //     $dateFinish = Carbon::now();
        //     $lamaPengerjaan = $ticket->created_at->diff($dateFinish)->format('%h jam %i menit'); 
        // }
        // $dateFinish = Carbon::parse($request->date_finish);

        // Hitung selisih waktu jika date_finish tersedia
        $lamaPengerjaan = $dateFinish ? $createdAt->diff($dateFinish)->format('%d hari %h jam %i menit') : null; 


        $ticket->update([
            'ticketing' => $request->ticketing,
            'problem' => $request->problem,
            'outlet' => $request->outlet,
            'status' => $request->status,
            'it_name' => $request->it_name,
            'date_finish' => $dateFinish,
            'lama_pengerjaan' => $lamaPengerjaan,
            // 'lama_pengerjaan' => $request->lama_pengerjaan,
        ]);

        session(['edit_step_'.$id => session('edit_step_'.$id, 1) + 1]);
         
        // Jika statusnya "OnProgress", tetap di halaman edit
        // if ($request->status == 'OnProgress') {
        //     return redirect()->back()->with('success', 'Status updated to OnProgress');
        // }

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
