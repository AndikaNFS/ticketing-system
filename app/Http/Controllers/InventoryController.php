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
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = Inventory::query()
    //         ->with([
    //             'category',
    //             'outlet',
    //             'assets.outlet',
    //         ])->withCount('assets');

    //     // Search
    //     if ($request->filled('search')) {
    //         $search = trim($request->search);

    //         $query->where(function ($q) use ($search) {
    //             $q->where('device', 'like', "%{$search}%")
    //                 ->orWhere('brand', 'like', "%{$search}%")
    //                 ->orWhere('description', 'like', "%{$search}%")
    //                 ->orWhere('placement', 'like', "%{$search}%")
    //                 ->orWhereHas('category', function ($categoryQuery) use ($search) {
    //                     $categoryQuery->where('name', 'like', "%{$search}%");
    //                 })
    //                 ->orWhereHas('outlet', function ($outletQuery) use ($search) {
    //                     $outletQuery->where('name', 'like', "%{$search}%");
    //                 });
    //         });
    //     }

    //     // Filter Category
    //     if ($request->filled('category_id')) {
    //         $query->where('category_id', $request->category_id);
    //     }

    //     // Filter Outlet
    //     if ($request->filled('outlet_id')) {
    //         $query->where('outlet_id', $request->outlet_id);
    //     }

    //     // Filter Entry Date - From
    //     if ($request->filled('entry_date')) {
    //         $query->whereDate('entry_date', $request->entry_date);
    //     }

    //     // Rows per page
    //     $allowedPerPage = [10, 20, 50, 100];

    //     $perPage = (int) $request->input('per_page', 10);
    //     if (! in_array($perPage, $allowedPerPage, true)) {
    //         $perPage = 10;
    //     }

        
    //     $inventories = $query->paginate(15)->withQueryString();
        
    //     $inventoryRows = collect();

    //     // Pagination
    //     $inventories = $query
    //         ->orderByDesc('id')
    //         ->paginate($perPage)
    //         ->withQueryString();

    //     foreach ($inventories as $inventory) {
    //         if ($inventory->is_tracked) {
    //             // Kelompokkan asset berdasarkan outlet saat ini
    //             $groupedAssets = $inventory->assets->groupBy('outlet_id');

    //             foreach ($groupedAssets as $outletId => $assets) {
    //                 $inventoryRows->push([
    //                     'inventory' => $inventory,
    //                     'outlet' => $assets->first()->outlet,
    //                     'quantity' => $assets->count(),
    //                     'assets_count' => $assets->count(),
    //                 ]);
    //             }
    //         } else {
    //             // Inventory Bulk tetap menggunakan outlet dan quantity Inventory
    //             $inventoryRows->push([
    //                 'inventory' => $inventory,
    //                 'outlet' => $inventory->outlet,
    //                 'quantity' => $inventory->quantity,
    //                 'assets_count' => 0,
    //             ]);
    //         }
    //     }

    //     // return view('inventory.index', compact(
    //     //     'inventories',
    //     //     'inventoryRows'
    //     // ));

    //     // Data untuk dropdown filter
    //     $categories = Category::orderBy('name')->get();
    //     $outlets = Outlet::orderBy('name')->get();

    //     // return view('inventory.inventories.index', compact('inventories', 'categories', 'outlets'));
    //     return view('inventory.inventories.index', compact('inventories', 'categories', 'outlets', 'inventoryRows'));
    // }
    public function index(Request $request)
    {
        $query = Inventory::query()
            ->with([
                'category',
                'outlet',
                'assets.outlet',
            ])
            ->withCount('assets');

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('device', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('placement', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    })
                    // Outlet saat ini untuk asset Tracked
                    ->orWhere(function ($outletQuery) use ($search) {
                        $outletQuery->where('is_tracked', true)
                            ->whereHas('assets.outlet', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    // Outlet Inventory untuk Bulk
                    ->orWhere(function ($outletQuery) use ($search) {
                        $outletQuery->where('is_tracked', false)
                            ->whereHas('outlet', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        // Filter Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Outlet berdasarkan lokasi asset saat ini
        if ($request->filled('outlet_id')) {
            $outletId = $request->outlet_id;

            $query->where(function ($q) use ($outletId) {
                $q->where(function ($trackedQuery) use ($outletId) {
                    $trackedQuery->where('is_tracked', true)
                        ->whereHas('assets', function ($assetQuery) use ($outletId) {
                            $assetQuery->where('outlet_id', $outletId);
                        });
                })->orWhere(function ($bulkQuery) use ($outletId) {
                    $bulkQuery->where('is_tracked', false)
                        ->where('outlet_id', $outletId);
                });
            });
        }

        // Filter Entry Date
        if ($request->filled('entry_date')) {
            $query->whereDate('entry_date', $request->entry_date);
        }

        // Rows per page
        $allowedPerPage = [10, 20, 50, 100];

        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        // Ambil seluruh Inventory yang sudah difilter.
        // Pagination dilakukan setelah pengelompokan.
        $inventories = $query
            ->orderByDesc('id')
            ->get();

        $trackedRows = collect();
        $bulkRows = collect();

        foreach ($inventories as $inventory) {
            if ($inventory->is_tracked) {
                // Kelompokkan asset berdasarkan outlet saat ini
                $assetsByOutlet = $inventory->assets->groupBy('outlet_id');

                foreach ($assetsByOutlet as $outletId => $assets) {
                    $outlet = $assets->first()->outlet;

                    if (!$outlet) {
                        continue;
                    }

                    $trackedRows->push([
                        'inventory' => $inventory,
                        'outlet' => $outlet,
                        'quantity' => $assets->count(),
                        'assets_count' => $assets->count(),
                    ]);
                }
            } else {
                // Bulk tetap mengikuti data Inventory
                $bulkRows->push([
                    'inventory' => $inventory,
                    'outlet' => $inventory->outlet,
                    'quantity' => $inventory->quantity,
                    'assets_count' => 0,
                    'inventories' => collect([$inventory]),
                    'is_grouped' => false,
                ]);
            }
        }

        // Gabungkan Tracked berdasarkan spesifikasi dan outlet
        $groupedTrackedRows = $trackedRows
            ->groupBy(function ($row) {
                $inventory = $row['inventory'];

                return implode('|', [
                    $inventory->device,
                    $inventory->brand,
                    $inventory->type,
                    $inventory->category_id,
                    $row['outlet']->id,
                ]);
            })
            ->map(function ($group) {
                $first = $group->first();

                return [
                    'inventory' => $first['inventory'],
                    'outlet' => $first['outlet'],
                    'quantity' => $group->sum('quantity'),
                    'assets_count' => $group->sum('assets_count'),

                    // Simpan semua Inventory sumber untuk referensi
                    'inventories' => $group
                        ->pluck('inventory')
                        ->unique('id')
                        ->values(),

                    'is_grouped' => $group->count() > 1,
                ];
            });

        // Gabungkan hasil Tracked dan Bulk
        $inventoryRows = $groupedTrackedRows
            ->concat($bulkRows)
            ->sortByDesc(function ($row) {
                return $row['inventory']->id;
            })
            ->values();

        // Pagination setelah pengelompokan
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $inventoryRows
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $inventoryRows = new LengthAwarePaginator(
            $currentItems,
            $inventoryRows->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Dropdown filter
        $categories = Category::orderBy('name')->get();
        $outlets = Outlet::orderBy('name')->get();

        return view('inventory.inventories.index', compact(
            'inventoryRows',
            'categories',
            'outlets'
        ));
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
            'inventory-template.xlsx'
        );
    }
}
