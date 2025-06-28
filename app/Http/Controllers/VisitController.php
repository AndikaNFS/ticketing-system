<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Outlet;
use App\Models\Ticket;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                                ->orWhere('it_name', 'like', '%' . $search . '%')
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
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        $outlets = Outlet::all();
        $specialOutlet = Outlet::find(22);
        return view('visits.create', compact('tickets', 'outlets', 'specialOutlet'));
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
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress',
            // 'images.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);

        Visit::create([
            'pic' => $request->pic,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'ticket_id' => null,
            'description' => $request->description,
            'status' => $request->status,
        ]);

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
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        $specialOutlet = Outlet::find(22);


        return view('visits.edit', compact('visits', 'outlets', 'tickets', 'specialOutlet'));
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
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress',
            // 'images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

        ]);
    
        $visit = Visit::findOrFail($id);
        $visit->update([
            'pic' => $request->pic,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'ticket_id' => $request->ticket_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $file) {
        //         $path = $file->store('images/visit', 'public');
        //         $visit->images()->create(['path' => $path]);
        //     }
        // }

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
        $image = Image::findOrFail($id);

        // Hapus file fisik
        Storage::delete('public/' . $image->path);

        // hapus dari database
        $image->delete();

        return back()->with('success', 'Gambar berhasil di hapus');
    }

}
