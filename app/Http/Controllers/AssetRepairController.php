<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\InventoryRepair;
use App\Models\Outlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssetRepairController extends Controller
{

    public function index (Request $request)
    {
        $query = InventoryRepair::with([
            'asset.inventory.category',
            'outlet',
        ]);

        // Filter outlet
        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by start date
        if ($request->filled('start_date')) {
            $query->whereDate(
                'repair_date',
                '>=',
                $request->start_date
            );
        }

        // Filter by end date
        if ($request->filled('end_date')) {
            $query->whereDate(
                'repair_date',
                '<=',
                $request->end_date
            );
        }

        $repairs = $query
            ->latest('repair_date')
            ->paginate(15)
            ->withQueryString();
        
        $outlets = Outlet::orderBy('name')->get();

        return view('inventory.assets.asset-repairs.index', compact('repairs', 'outlets'));
    }

    public function create(Asset $asset)
    {
        if (in_array($asset->status, ['Repair', 'Lost', 'Disposed',], true)) {
            return redirect()->route('assets.show', $asset)->with(
                'error',
                "An asset with status {$asset->status} cannot be sent for repair."
            );
        }
        
        $asset->load([
            'inventory.category',
            'outlet',
        ]);
        
    
        return view('inventory.assets.asset-repairs.create', compact('asset'));
    }

    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'repair_date' => 'required|date',
            'cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $asset) {
            $lockedAsset = Asset::whereKey($asset->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (in_array($lockedAsset->status, [
                'Repair',
                'Lost',
                'Disposed',
            ], true)) {
                throw ValidationException::withMessages([
                    'repair_date' =>
                        "An asset with status {$lockedAsset->status} cannot be sent for repair.",
                ]);
            }
            // if ($lockedAsset->status === 'Repair') {
            //     throw ValidationException::withMessages([
            //         'repair_date' => 'This asset is already under repair.',
            //     ]);
            // }

            InventoryRepair::create([
                'inventory_id' => $lockedAsset->inventory_id,
                'asset_id' => $lockedAsset->id,
                'outlet_id' => $lockedAsset->outlet_id,
                'repair_date' => $validated['repair_date'],
                'status' => 'Repair',
                'description' => $validated['description'] ?? null,
                'cost' => $validated['cost'],
                'completed_at' => null,
            ]);

            // Update asset status.
            $lockedAsset->update([
                'status' => 'Repair',
            ]);
        });

        return redirect()->route('assets.show', $asset)->with('success', 'Asset repair process started successfully.');
    }

    public function show(InventoryRepair $repair)
    {
        $repair->load([
            'asset.inventory.category',
            'asset.outlet',
            'outlet',
        ]);

        return view('inventory.assets.asset-repairs.show', compact('repair'));
    }

    public function complete(Request $request, InventoryRepair $repair)
    {
        $validated = $request->validate([
            'completed_at' => 'required|date',
            'asset_status' => 'required|in:Available, In Use, Broken',
        ]);
        
        DB::transaction(function () use ($validated, $repair) {
            $lockedRepair = InventoryRepair::whereKey($repair->id)
                ->lockForUpdate()
                ->firstOrFail();

            // A completed repair cannot be completed again.
            if ($lockedRepair->status === 'Completed') {
                throw ValidationException::withMessages([
                    'completed_at' => 'This repair has already been completed.',
                ]);
            }

            // Ambil asset dan lock
            $lockedAsset = Asset::whereKey($lockedRepair->asset_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan asset sedang Repair
            if ($lockedAsset->status !== 'Repair') {
                throw ValidationException::withMessages([
                    'asset_status' => 'The asset status is not Repair.'
                ]);
            }

            // Ensure the completion date is not before the start date.
            if (
                strtotime($validated['completed_at']) < strtotime($lockedRepair->repair_date)
            ) {
                throw ValidationException::withMessages([
                    'completed_at' => 'The completion date cannot be earlier than the repair start date.',
                ]);
            }

            // Update repair history.
            $lockedRepair->update([
                'status' => 'Completed',
                'completed_at' => $validated['completed_at'],
            ]);

            // Update asset status.
            $lockedAsset->update([
                'status' => $validated['asset_status'],
            ]);
        });

        return redirect()->route('assets.repairs.show', $repair)->with('success', 'Repair completed successfully.');
    }
}
