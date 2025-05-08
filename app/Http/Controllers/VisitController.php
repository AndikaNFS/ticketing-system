<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Ticket;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $visits = Visit::all();
        $search = $request->input('search');

        $visits = Visit::with(['outlet', 'ticket'])
            ->when($search, function ($query) use ($search) {
                $query->where('pic', 'like', '%' . $search . '%')
                        ->orWhereHas('ticket', function ($q) use ($search) {
                            $q->where('ticketing', 'like', '%' . $search . '%')
                                ->orWhere('problem', 'like', '%' . $search . '%');
                        });
            })
        ->orderBy('tanggal_visit', 'desc')
        ->paginate(10);

        return view('visits.index', compact('visits', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tickets = Ticket::all();
        $outlets = Outlet::all();
        return view('visits.create', compact('tickets', 'outlets'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pic' => 'required|string|max:255',
            'tanggal_visit' => 'required|string|max:255',
            'outlet_id' => 'required|string|max:255',
            'ticket_id' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $visit = Visit::create([
            'pic' => $request->pic,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'ticket_id' => $request->ticket_id,
            'description' => null,
        ]);

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
        $tickets = Ticket::all();

        return view('visits.edit', compact('visits', 'outlets', 'tickets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit, $id)
    {
        $request->validate([
            'pic' => 'required|string|max:255',
            'tanggal_visit' => 'required|date',
            'outlet_id' => 'required|exists:outlets,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'description' => 'nullable|string|max:255',

        ]);
    
        $visit = Visit::findOrFail($id);
        $visit->update([
            'pic' => $request->pic,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'ticket_id' => $request->ticket_id,
            'description' => $request->description,
        ]);

        return redirect()->route('visits.index')->with('success', 'Data berhasil di simpan');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
