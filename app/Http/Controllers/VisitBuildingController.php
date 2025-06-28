<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Employeebuild;
use App\Models\Outlet;
use App\Models\Ticket;
use App\Models\VisitBuilding;
use Illuminate\Http\Request;

class VisitBuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $search = $request->input('search');

    $visits = VisitBuilding::with(['outlet', 'building'])
            ->when($search, function ($query) use ($search) {
                $query->where('employeebuild', 'like', '%' . $search . '%')
                        ->orWhereHas('building', function ($q) use ($search) {
                            $q->where('ticketing', 'like', '%' . $search . '%')
                                ->orWhere('pic', 'like', '%' . $search . '%')
                                ->orWhere('problem', 'like', '%' . $search . '%');
                        });
            })
    ->orderBy('tanggal_visit', 'desc')
    ->paginate(10);


        return view('building.visits.index', compact('visits', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tickets = Building::orderBy('created_at', 'desc')->get();
        $outlets = Outlet::all();
        $specialOutlet = Outlet::find(22);
        $employees = Employeebuild::all();
        return view('building.visits.create', compact('tickets','employees', 'outlets', 'specialOutlet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employeebuild' => 'required|string|max:255',
            'tanggal_visit' => 'required|string|max:255',
            'outlet_id' => 'required|string|max:255',
            'building_id' => 'nullable|string|max:255',
            'jobdesk' => 'nullable|string|max:255',
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress',
            // 'images.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);

        VisitBuilding::create([
            'employeebuild' => $request->employeebuild,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'building_id' => null,
            'jobdesk' => $request->jobdesk,
            'status' => $request->status,
        ]);
        
        return redirect()->route('building.visits.index')->with('success', 'Data berhasil di simpan');

    }

    /**
     * Display the specified resource.
     */
    public function show(VisitBuilding $visitBuilding, $id)
    {
        $visits = VisitBuilding::where('id', $id)->get();

        return view('building.visits.detail', compact('visits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitBuilding $visitBuilding, $id)
    {
        $visits = VisitBuilding::findOrFail($id);
        $tickets = Building::orderBy('created_at', 'desc')->get();
        $outlets = Outlet::all();
        $employees = Employeebuild::all();
        $specialOutlet = Outlet::find(22);


        return view('building.visits.edit', compact('employees','visits', 'outlets', 'tickets', 'specialOutlet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisitBuilding $visitBuilding, $id)
    {
        $request->validate([
            'employeebuild' => 'required|string|max:255',
            'tanggal_visit' => 'required|date',
            'outlet_id' => 'required|exists:outlets,id',
            'building_id' => 'nullable|exists:buildings,id',
            'jobdesk' => 'nullable|string|max:255',
            'status' => 'required|in:Cancelled,Finished,Reschedule,InProgress',
            // 'images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

        ]);
    
        $visit = VisitBuilding::findOrFail($id);
        $visit->update([
            'employeebuild' => $request->employeebuild,
            'tanggal_visit' => $request->tanggal_visit,
            'outlet_id' => $request->outlet_id,
            'building_id' => $request->building_id,
            'jobdesk' => $request->jobdesk,
            'status' => $request->status,
        ]);

        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $file) {
        //         $path = $file->store('images/visit', 'public');
        //         $visit->images()->create(['path' => $path]);
        //     }
        // }

        return redirect()->route('building.visits.index')->with('success', 'Data berhasil di simpan');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitBuilding $visitBuilding)
    {
        //
    }
}
