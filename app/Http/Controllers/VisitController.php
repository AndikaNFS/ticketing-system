<?php

namespace App\Http\Controllers;

use App\Exports\VisitExport;
use App\Models\Image;
use App\Models\ImageVisit;
use App\Models\Outlet;
use App\Models\Ticket;
use App\Models\Visit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
        $it_name    = $request->input('it_name');

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
        if ($it_name) {
            $visits->where('it_name', $it_name);
        }
        
        // $search = $request->input('search');
        if ($search) {
            $visits = Visit::with(['outlet', 'ticket'])
                ->when($search, function ($query) use ($search) {
                    $query->where('pic', 'like', '%' . $search . '%')
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


        return view('visits.index', compact('visits', 'search', 'outlets', 'search', 'startDate', 'endDate', 'it_name', 'outlet_id'));
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
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress,Open',
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
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress,Open',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:20480',

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

}
