<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Outlet;
use App\Models\Asset;
use App\Models\Category;
use App\Models\InventoryTransfer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $outletId = $request->input('outlet_id');
        // $specialOutlet = Outlet::where('id', '!=', 22)->get();

        // Ambil seluruh outlet beserta jumlah asset dan inventory
        $outlets = Outlet::withCount(['assets', 'inventories'])
            ->where('id', '!=', 22)
            ->orderBy('name')
            ->get();

        // Ambil outlet yang dipilih
        $selectedOutlet = $outletId
            ? $outlets->firstWhere('id', $outletId)
            : null;

        // Siapkan daftar outlet yang akan ditampilkan
        $displayOutlets = $selectedOutlet
            ? collect([$selectedOutlet])
            : $outlets;

        // Query pencarian asset
        $assets = Asset::with([
            'inventory.category',
            'outlet',
        ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('serial_number', 'like', "%{$search}%")
                        ->orWhere('asset_number', 'like', "%{$search}%");
                });
            })
            ->when($outletId, function ($query, $outletId) {
                $query->where('outlet_id', $outletId);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('inventory.assets.index', compact(
            'outlets',
            'displayOutlets',
            'selectedOutlet',
            'assets',
            'search',
            'outletId',
        ));
    }

    // public function outlet(Outlet $outlet, Request $request)
    // {
    //     $query = $outlet->assets()
    //         ->with(['inventory.category', 'images'])
    //         ->withCount('images');

    //     $inventories = $outlet->inventories()
    //         ->with('category')
    //         ->orderBy('device')
    //         ->get();

    //     $assets = $outlet->assets()
    //         ->with(['inventory.category', 'images',])
    //         ->withCount('images')
    //         ->latest()
    //         ->paginate(15);


    //     $totalBulkUnits = $inventories
    //         ->where('is_tracked', false)
    //         ->sum('quantity');


    //     $totalInventories = $inventories->count();
    //     $totalIndividualAssets = $outlet->assets()->count();

    //     // Rows per page
    //     $allowedPerPage = [10, 20, 50, 100];

    //     $perPage = (int) $request->input('per_page', 10);
    //     if (! in_array($perPage, $allowedPerPage, true)) {
    //         $perPage = 10;
    //     }

    //     // Pagination
    //     $assets = $query
    //         ->orderByDesc('id')
    //         ->paginate($perPage)
    //         ->withQueryString();

    //     return view('inventory.assets.outlet', compact('outlet', 'inventories', 'assets', 'totalBulkUnits', 'totalIndividualAssets', 'totalInventories'));
    // }

    public function outlet(Outlet $outlet, Request $request)
    {
        return $this->showOutletAssets($outlet, $request, 'inventory.assets.outlet');
    }

    public function warehouse(Outlet $outlet, Request $request)
    {
        return $this->showOutletAssets($outlet, $request, 'inventory.assets.warehouse');
    }

    private function showOutletAssets(
        Outlet $outlet,
        Request $request,
        string $view
    ) {
        $search = $request->input('search');

        $allowedPerPage = [10, 20, 50, 100];

        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        $inventories = $outlet->inventories()
            ->with('category')
            ->orderBy('device')
            ->get();
        
            
        $query = $outlet->assets()
        ->with([
            'inventory.category', 
            'images',
            'latestTransfer.fromOutlet',
            ])
            ->withCount('images');
            
        // Filter Category
        if ($request->filled('category_id')) {
            $query->whereHas('inventory', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }
        $query->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('asset_number', 'like', "%{$search}%")
                    ->orWhereHas('inventory', function ($inventoryQuery) use ($search) {
                        $inventoryQuery->where('device', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%")
                            ->orWhere('type', 'like', "%{$search}%");
                    });
            });
        });

        $assets = $query
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $totalBulkUnits = $inventories
            ->where('is_tracked', false)
            ->sum('quantity');

        $totalInventories = $inventories->count();

        $totalIndividualAssets = $outlet->assets()->count();

        // $categories = Category::whereHas('inventories', function ($query) use ($outlet) {
        //     $query->where('outlet_id', $outlet->id);
        // })->orderBy('name')->get();

        $categoryIds = $outlet->assets()
            ->join('inventories', 'assets.inventory_id', '=', 'inventories.id')
            ->distinct()
            ->pluck('inventories.category_id');

        $categories = Category::whereIn('id', $categoryIds)
            ->orderBy('name')
            ->get();


        return view($view, compact(
            'outlet',
            'inventories',
            'assets',
            'totalBulkUnits',
            'totalIndividualAssets',
            'totalInventories',
            'search',
            'perPage',
            'categories',
        ));
    }

    public function create(Outlet $outlet)
    {
        $inventories = Inventory::with('category')
            ->withCount('assets')
            ->where('is_tracked', true)
            ->where('outlet_id', $outlet->id)
            ->orderBy('device')
            ->get();

        return view('inventory.assets.create', compact('outlet', 'inventories'));
    }

    public function store (Request $request, Outlet $outlet)
    {
        $validated = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'serial_number' => 'nullable|string|max:150',
            'asset_number' => 'nullable|string|max:150',
            'status' => ['required', Rule::in(['Available', 'In Use', 'Repair', 'Broken', 'Lost', 'Unavailable',])],
            'placement' => 'nullable|string|max:150',
            'entry_date' => 'required|date',
            'description' => 'nullable|string|max:250',
        ]);

        $inventory = Inventory::where('id', $validated['inventory_id'])
            ->where('is_tracked', true)
            ->where('outlet_id', $outlet->id)
            ->firstOrFail();

        // Count the assets that have already been created.
        $assetCount = Asset::where('inventory_id', $inventory->id)->count();

        // Ensure the asset count does not exceed the inventory quantity.
        if ($assetCount >= $inventory->quantity) {
            return back()
                    ->withInput()
                    ->with(
                        'error', "The asset quantity for {$inventory->device} has reached the inventory quantity ({$inventory->quantity})."
                    );
        }

        // Check the serial number if provided.
        if (!empty($validated['serial_number'])) {
            $serialExists = Asset::where('serial_number', $validated['serial_number'])->exists();

            if ($serialExists) {
                return back()
                        ->withInput()
                        ->with('error', "This serial number is already assigned to another asset.");
            }
        }

        // Check the asset number if provided.
        if (!empty($validated['asset_nnumber'])) {
            $assetNumberExists = Asset::where('asset_number', $validated['asset_number'])->exists();

            if ($assetNumberExists) {
                return back()
                    ->withInput()
                    ->with('error', "This asset number is already assigned to another asset.");
            }
        }

        Asset::create([
            'inventory_id' => $inventory->id,
            'outlet_id' => $outlet->id,
            'serial_number' => $validated['serial_number'] ?? null,
            'asset_number' => $validated['asset_number'] ?? null,
            'status' => $validated['status'],
            'placement' => $validated['placement'] ?? null,
            'entry_date' => $validated['entry_date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('assets.outlet', $outlet)
            ->with('success', 'Asset added successfully.');
    }

    public function show(Asset $asset)
    {
        $asset->load([
            'inventory.category',
            'outlet',
            'images.outlet',
        ]);

        return view('inventory.assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $asset->load([
            'inventory.category',
            'outlet',
        ]);
        
        return view('inventory.assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'serial_number' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('assets', 'asset_number')->ignore($asset->id),
            ],

            'status' => [
                'required',
                Rule::in(['Available', 'In Use', 'Repair', 'Broken', 'Lost', 'Unavailable']),
            ],
            
            'placement' => [
                'nullable',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'asset_number' => [
                'nullable',
                'string',
                'max:150',
            ],
            'entry_date' =>[
                'required',
                'date',
            ],
        ]);

        if ($asset->status === 'Unavailable' && $validated['status'] !== 'Unavailable') {
            return back()->withInput()->with(
                'error',
                "A disposed asset cannot be changed to another status."
            );
        }

        $asset->update([
            'serial_number' => $validated['serial_number'] ?? null,
            'asset_number' => $validated['asset_number'] ?? null,
            'status' => $validated['status'],
            'placement' => $validated['placement'] ?? null,
            'entry_date' => $validated['entry_date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('assets.outlet', $asset->outlet_id)->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->transfers()->exists()) {
            return back()
                ->with('error', 'This asset cannot be deleted because it has transfer history.');
        }

        $outletId = $asset->outlet_id;

        $asset->delete();

        return redirect()->route('inventory.assets.outlet', $outletId)->with('success', 'Asset deleted successfully.');
    }
}
