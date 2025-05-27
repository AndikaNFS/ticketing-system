<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Areait;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $outlets = Outlet::all();
        // $search = $request->input
        $areaits = Areait::all();

        return view('outlets.index', compact('areaits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $outlets = Outlet::all();
        $areas = Area::all();


        return view('outlets.create', compact('outlets','areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'area_id'=>'required|string|max:255',
            'it_name'=>'required|string|max:50',
            'pic'=>'required|string|max:50',
            'outlet_id'=>'required|string|max:50',
            
        ]);

        Areait::create([
            'area_id' => $request->area_id,
            'it_name' => $request->it_name,
            'pic' => $request->pic,
            'outlet_id' => $request->outlet_id,
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
        $areaits = Areait::findOrFail($id);
        $outlets = Outlet::all();
        $areas = Area::all();

        return view('outlets.edit', compact('areaits', 'outlets', 'areas'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area, $id)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'it_name'=>'required|string|max:50',
            'pic'=>'required|string|max:50',
            'outlet_id'=>'required|string|max:50',
            
        ]);

        $area = Areait::findOrFail($id);
        $area->update([
            'name' => $request->name,
            'it_name' => $request->it_name,
            'pic' => $request->pic,
            'outlet_id' => $request->outlet_id,

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
