<?php

namespace App\Http\Controllers;

use App\Models\AssetTransferImage;
use App\Models\InventoryTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetTransferImageController extends Controller
{
    public function store(Request $request, InventoryTransfer $transfer)
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max: 5120',
            ],
            'image_type' => ['required', 'in:handover,condition'],
        ]);

        $storedFiles = [];

        try {
            foreach ($validated['images'] as $image) {
                $imagePath = $image->store(
                    'assets/transfers', 'public'
                );

                if (!$imagePath) {
                    throw new \RuntimeException('Gagal menyimpan foto transfer.');
                }

                $storedFiles[] = $imagePath;

                $transfer->images()->create([
                    'image_path' => $imagePath,
                    'image_type' => $validated['image_type'],
                ]);
            }
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($storedFiles);

            report($e);

            return back()->with(
                'error',
                'Gagal mengupload foto transfer.'
            );
        }

        return back()->with(
            'success',
            count($storedFiles) . ' foto transfer berhasil diupload.'
        );

    }

    public function destroy(InventoryTransfer $transfer, AssetTransferImage $image)
    {
        $transferImage = $transfer->images()->where('id', $image->id)->firstOrFail();

        Storage::disk('public')->delete($transferImage->image_path);

        $transferImage->delete();

        return back()->with(
            'success',
            'Foto transfer berhasil dihapus'
        );
    }
}
