<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Areait;
use App\Models\Employee;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlets = Outlet::all();
        // $search = $request->input
        // $outlets = Outlet::with(['employee']);
        $employees = Employee::all();

        return view('outlets.index', compact('outlets','employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $outlets = Outlet::all();
        // $areas = Area::all();


        return view('outlets.create', compact('outlets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'area'=>'required|string|max:255',
            'it_name'=>'nullable|string|max:50',
            'pic'=>'required|string|max:50',
            // 'outlet_id'=>'required|string|max:50',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'employee_id' => 'nullable|string|max:50',
            
        ]);

        Areait::create([
            'area' => $request->area,
            'it_name' => $request->it_name,
            'pic' => $request->pic,
            'area' => $request->area,
            'location' => $request->location,
            'employee_id' => $request->employee_id,
            // 'outlet_id' => $request->outlet_id,
        ]);

        return redirect()->route('outlets.index')->with('success', 'Data berhasil di simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Outlet $outlet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $areaits = Areait::findOrFail($id);
        $outlets = Outlet::findOrFail($id);
        $areas = Area::all();

        return view('outlets.edit', compact( 'outlets', 'areas'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area, $id)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'it_name'=>'nullable|string|max:50',
            'pic'=>'required|string|max:50',
            'area' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'employee_id'=>'nullable|string|max:50',
            
        ]);

        $area = Areait::findOrFail($id);
        $area->update([
            'name' => $request->name,
            'it_name' => $request->it_name,
            'pic' => $request->pic,
            'area' => $request->area,
            'location' => $request->location,
            'employee_id' => $request->outlet_id,

        ]);

        return redirect()->route('outlets.index')->with('success', 'Data berhasil di simpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outlet $outlet)
    {
        //
    }
}
