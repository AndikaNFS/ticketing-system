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
        $outlets = Outlet::withCount('assets')
            ->orderBy('name')
            ->paginate(12);

        return view ('inventory.assets.index', compact('outlets'));
    }

    public function outlet(Outlet $outlet)
    {
        $assets = $outlet->assets()
            ->with([
                'inventory.category',
            ])
            ->latest()
            ->paginate(15);

        return view('inventory.assets.outlet', compact('outlet', 'assets'));
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

        // Hitung jumlah asset yang sudah dibuat
        $assetCount = Asset::where('inventory_id', $inventory->id)->count();

        // Jangan sampai asset melebihi quantity Inventory
        if ($assetCount >= $inventory->quantity) {
            return back()
                    ->withInput()
                    ->with(
                        'error', "Jumlah Asset untuk {$inventory->device} sudah mencapai quantity Inventory ({$inventory->quantity})."
                    );
        }

        // Cek serial number jika di isi
        if (!empty($validated['serial_number'])) {
            $serialExists = Asset::where('serial_number', $validated['serial_number'])->exists();

            if ($serialExists) {
                return back()
                        ->withInput()
                        ->with('error', "Serial Number tersebut sudah digunakan oleh Asset lain.");
            }
        }

        // Cek Asset Number jika di isi
        if (!empty($validated['asset_nnumber'])) {
            $assetNumberExists = Asset::where('asset_number', $validated['asset_number'])->exists();

            if ($assetNumberExists) {
                return back()
                    ->withInput()
                    ->with('error', "Asset Number tersebut sudah di gunakan oleh Asset lain.");
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
            ->with('success', 'Asset berhasil ditambah');
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
                "Asset yang sudah Disposed tidak dapat dikembalikan ke status lain."
            );
        }

        $asset->update([
            'serial_number' => $validated['serial_number'] ?? null,
            'asset_number' => $validated['asset_number'] ?? null,
            'status' => $validated['status'],
            'placement' => $validated['placement'] ?? null,
            'entry_date' => $validated['entry_date'],
        ]);

        return redirect()->route('assets.outlet', $asset->outlet_id)->with('success', 'Asset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->transfers()->exists()) {
            return back()
                ->with('error', 'Asset tidak dapat dihapus karena sudah memiliki riwayat transfer.');
        }

        $outletId = $asset->outlet_id;

        $asset->delete();

        return redirect()->route('inventory.assets.outlet', $outletId)->with('success', 'Asset berhasil dihapus');
    }
}
