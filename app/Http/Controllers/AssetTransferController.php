<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Outlet;
use App\Models\InventoryTransfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssetTransferController extends Controller
{
    public function index (Request $request)
    {
        $query = InventoryTransfer::with([
            'asset.inventory.category',
            'fromOutlet',
            'toOutlet',
            'creator',
        ]);

        // Filter outlet asal
        if ($request->filled('from_outlet_id')) {
            $query->where('from_outlet_id', $request->from_outlet_id);
        }

        // Filter outlet tujuan
        if ($request->filled('to_outlet_id')) {
            $query->where('to_outlet_id', $request->to_outlet_id);
        }

        // Filter tanggal awal
        if ($request->filled('start_date')) {
            $query->whereDate(
                'transfer_date',
                '>=',
                $request->start_date
            );
        }

        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate(
                'tranfer_date',
                '<=',
                $request->end_date
            );
        }

        $transfers = $query
            ->latest('transfer_date')
            ->paginate(15)
            ->withQueryString();

        $outlets = Outlet::orderBy('name')->get();

        return view('inventory.assets.asset-transfers.index', compact('transfers', 'outlets'));

    }

    public function create(Asset $asset)
    {
        // $asset->load([
        //     'inventory.category',
        //     'outlet',
        // ]);

        // $outlets = Outlet::where('id', '!=', $asset->outlet_id)
        //     ->orderBy('name')
        //     ->get();

        if (in_array($asset->status, ['Repair', 'Lost', 'Disposed'], true)) {
            return redirect()->route('assets.show', $asset)->with(
                'error',
                "Asset dengan status {$asset->status} tidak dapat ditransfer."
            );
        }

        $asset->load(['inventory.category', 'outlet']);

        $outlets = Outlet::where('id', '!=', $asset->outlet_id)
            ->orderBy('name')
            ->get();
        
        return view('inventory.assets.asset-transfers.create', compact('asset', 'outlets'));
    }

    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'to_outlet_id' => 'required|exists:outlets,id',
            'transfer_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $asset) {

            // Ambil ulang Asset dan kunci record selama transaksi.
            $lockedAsset = Asset::whereKey($asset->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Validasi status asset
            if (in_array($lockedAsset->status, [
                'Repair',
                'Lost',
                'Disposed',
            ], true)) {
                throw ValidationException::withMessages([
                    'to_outlet_id' => "Asset dengan status {$lockedAsset->status} tidak dapat ditransfer.",
                ]);
            }

            // Pastikan Asset tidak di pindahkan ke outlet yg sama
            if ((int) $validated['to_outlet_id'] === (int) $lockedAsset->outlet_id) {
                throw ValidationException::withMessages([
                    'to_outlet_id' => 'Outlet tujuan harus berbeda dengan outlet asal.',
                ]);
            }

            $fromOutletId = $lockedAsset->outlet_id;

            // Simpan riawat transfer
            InventoryTransfer::create([
                'inventory_id' => $lockedAsset->inventory_id,
                'asset_id' => $lockedAsset->id,
                'from_outlet_id' => $fromOutletId,
                'to_outlet_id' => $validated['to_outlet_id'],
                'quantity' => 1,
                'transfer_date' => $validated['transfer_date'],
                'status' => 'completed',
                'description' => $validated['description'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Perbarui lokasi asset.
            $lockedAsset->update([
                'outlet_id' => $validated['to_outlet_id'],
            ]);
        });

        return redirect()->route('assets.show', $asset)->with('success', 'Asset berhasil ditransfer.');
    }
}
