<?php

namespace App\Http\Controllers;

use App\Exports\InventoryTemplateExport;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Outlet;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::query()
            ->with([
                'category',
                'outlet',
            ])->withCount('assets');

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('device', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('placement', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('outlet', function ($outletQuery) use ($search) {
                        $outletQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Outlet
        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        // Filter Entry Date - From
        if ($request->filled('entry_date')) {
            $query->whereDate('entry_date', $request->entry_date);
        }

        // Filter Entry Date - To
        // if ($request->filled('date_to')) {
        //     $query->where('entry_date', '<=', $request->date_to);
        // }

        // Rows per page
        $allowedPerPage = [10, 20, 50, 100];

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        // $inventories = $query
        //     ->latest()
        //     ->paginate(15)
        //     ->withQueryString();

        // Pagination
        $inventories = $query
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        // Data untuk dropdown filter
        $categories = Category::orderBy('name')->get();
        $outlets = Outlet::orderBy('name')->get();



        // $inventories = Inventory::with([
        //     'category',
        //     'outlet',
        //     'sourceOutlet',
        //     // 'assets',
        // ])
        // ->withCount('assets')
        // ->latest()
        // ->paginate(10);

        return view('inventory.inventories.index', compact('inventories', 'categories', 'outlets'));
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
            'type' => 'nullable|string|max:100',
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

        Inventory::create([
            'category_id' => $validated['category_id'],
            'outlet_id' => $validated['outlet_id'],
            'sources_outlet_id' => $validated['sources_outlet_id'] ?? null,
            'device' => $validated['device'],
            'brand' => $validated['brand'] ?? null,
            'type' => $validated['type'] ?? null,
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
        // $inventory = Inventory::with([
        //     'category',
        //     // 'device',
        //     'outlet',
        //     'sourceOutlet',
        //     'assets',
        //     'images',
        // ]);

        $inventory->load(['category', 'outlet', 'sourceOutlet', 'assets', 'images',]);

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

        return view('inventory.inventories.edit', compact('inventory', 'categories', 'outlets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'device' => 'required|string|max:150',
            'brand' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'outlet_id' => 'required|exists:outlets,id',
            'sources_outlet_id' => 'nullable|exists:outlets,id',
            'is_tracked' => 'required|boolean',
            'quantity' => 'required|integer|min:1',
            'placement' => 'nullable|string|max:150',
            'entry_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $assetCount = $inventory->assets()->count();

        // Validasi Quantity
        if ($validated['quantity'] < $assetCount) {
            return back()->withInput()
                ->with(
                    'error',
                    'Quantity cannot be less than the number of assets already created ({$assetCount} Asset).'
                );
        }

        // Inventory Tracked -> Bulk
        if (!$validated['is_tracked'] && $assetCount > 0) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    "Inventory cannot be changed to Bulk because it still has {$assetCount} Asset."
                );
        }

        // Outlet Inventory
        if((int) $validated['outlet_id'] !== (int) $inventory->outlet_id && $assetCount >0) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The inventory outlet cannot be changed because this inventory already has assets. Use the Transfer Asset feature to move assets.'
                );
        }

        $inventory->update([
            'category_id' => $validated['category_id'],
            'outlet_id' => $validated['outlet_id'],
            'sources_outlet_id' => $validated['sources_outlet_id'] ?? null,
            'device' => $validated['device'],
            'brand' => $validated['brand'] ?? null,
            'type' => $validated['type'] ?? null,
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

    public function downloadTemplate()
    {
        $categories = Category::orderBy('name')
            ->pluck('name')
            ->toArray();
        $outlets = Outlet::orderby('name')
            ->pluck('name')
            ->toArray();
        return Excel::download(
            new InventoryTemplateExport($categories, $outlets),
            'new-inventory-template.xlsx'
        );
    }
}
