<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Outlet;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with([
            'category',
            'outlet',
            'sourceOutlet',
            // 'assets',
        ])
        ->withCount('assets')
        ->latest()
        ->paginate(10);

        return view('inventory.inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $outlets = Outlet::orderBy('name')->get();

        return view('inventory.inventories.create', compact('categories', 'outlets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device' => 'required|string|max:150',
            'brand' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'outlet_id' => 'required|exists:outlets,id',
            'sources_outlet_id' => 'nullable|exists:outlets,id',
            'is_tracked' => 'required|boolean',
            'quantity' => 'required|integer|min:1',
            // 'serial_number' => 'required|string|max:150|unique:assets,serial_number',
            // 'asset_number' => 'nullable|string|max:150|unique:assets,asset_number',
            // 'status' => ['required', Rule::in(['Available', 'In Use', 'Repair', 'Broken', 'Lost', 'Disposed'])],
            'placement' => 'nullable|string|max:150',
            'entry_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $inventory = Inventory::create([
            'category_id' => $validated['category_id'],
            'outlet_id' => $validated['outlet_id'],
            'sources_outlet_id' => $validated['sources_outlet_id'] ?? null,
            'device' => $validated['device'],
            'brand' => $validated['brand'] ?? null,
            'is_tracked' => $validated['is_tracked'],
            'quantity' => $validated['quantity'],
            'placement' => $validated['placement'] ?? null,
            'entry_date' => $validated['entry_date'],
            'description' => $validated['description'] ?? null,
        ]);
        // DB::transaction(function () use ($validated) {

        //     if ($validated['is_serialized']) {
        //         $inventory->assets()->create([
        //             'outlet_id' => $validated['outlet_id'],
        //             'serial_number' => $validated['serial_number'],
        //             'asset_number' => $validated['asset_number'] ?? null,
        //             'status' => $validated['status'],
        //             'placement' => $validated['placement'] ?? null,
        //             'entry_date' => $validated['entry_date'],
        //         ]);
        //     }

        // });

        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        $inventory = Inventory::with([
            'category',
            'outlet',
            'sourceOutlet',
            'assets',
            'images',
        ]);

        return view('inventory.inventories.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();
        $outlets = Outlet::orderBy('name')->get();

        $inventory->load('assets');

        return view('inventories.edit', compact('inventory', 'categories', 'outlets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'device' => 'required|string|max:150',
            'brand' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'outlet_id' => 'required|exists:outlets,id',
            'sources_outlet_id' => 'nullable|exists:outlets,id',
            'quality' => 'required|integer|min:1',
            'placement' => 'nullable|string|max:150',
            'entry_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $inventory->update([
            'category_id' => $validated['category_id'],
            'outlet_id' => $validated['outlet_id'],
            'sources_outlet_id' => $validated['sources_outlet_id'] ?? null,
            'device' => $validated['device'],
            'brand' => $validated['brand'] ?? null,
            'is_tracked' => $validated['is_tracked'],
            'quantity' => $validated['quantity'],
            'placement' => $validated['placement'] ?? null,
            'entry_date' => $validated['entry_date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        if ($inventory->assets()->exists()) {
            return redirect()->route('inventories.index')->with('error', 'Cannot delete inventory with associated Asset.');
        }
        if ($inventory->transfers()->exists()) {
            return redirect()->route('inventories.index')->with('error', 'Cannot delete inventory with associated transfers.');
        }

        if ($inventory->repairs()->exists()) {
            return redirect()->route('inventories.index')->with('error', 'Cannot delete inventory with associated repairs.');
        }

        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');
    }
}
