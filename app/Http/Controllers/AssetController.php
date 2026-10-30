<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Outlet;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index()
    {
        $outlets = Outlet::withCount(['assets', 'inventories'])
            ->orderBy('name')
            ->paginate(12);

        return view ('inventory.assets.index', compact('outlets'));
    }

    public function outlet(Outlet $outlet)
    {
        // $assets = $outlet->assets()
        //     ->with([
        //         'inventory.category',
        //     ])
        //     ->latest()
        //     ->paginate(15);

        $inventories = $outlet->inventories()
            ->with('category')
            ->orderBy('device')
            ->get();

        $assets = $outlet->assets()
            ->with(['inventory.category', 'images',])
            ->withCount('images')
            ->latest()
            ->paginate(15);

        // $images = $outlet->imageAssets()
        //     ->with(['images.outlet'])
        //     ->latest()
        //     ->get();

        $totalBulkUnits = $inventories
            ->where('is_tracked', false)
            ->sum('quantity');

        $totalInventories = $inventories->count();
        $totalIndividualAssets = $outlet->assets()->count();

        // $totalImage = $images->imageAssets()->count();

        return view('inventory.assets.outlet', compact('outlet', 'inventories', 'assets', 'totalBulkUnits', 'totalIndividualAssets', 'totalInventories'));
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
            'status' => ['required', Rule::in(['Available', 'In Use', 'Repair', 'Broken', 'Lost', 'Disposed',])],
            'placement' => 'nullable|string|max:150',
            'entry_date' => 'required|date',
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
                Rule::in(['Avilable', 'In Use', 'Repair', 'Broken', 'Lost', 'Disposed',]),
            ],
            
            'placement' => [
                'nullable',
                'string',
                'max:150',
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

        if ($asset->status === 'Disposed' && $validated['status'] !== 'Disposed') {
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
