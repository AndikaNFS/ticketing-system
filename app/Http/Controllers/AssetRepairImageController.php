<?php

namespace App\Http\Controllers;

use App\Models\AssetRepairImage;
use App\Models\InventoryRepair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetRepairImageController extends Controller
{
    public function store(Request $request, InventoryRepair $repair)
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => [
                'required',
                'image',
                'mimes:jpg,png,jpeg,webp',
                'max:5120',
            ],
            'image_type' => ['required', 'in:Damage,Process,Result'],
        ]);

        $storedFiles = [];

        try {
            foreach ($validated['images'] as $image) {
                $imagePath = $image->store(
                    'assets/repairs', 'public'
                );

                if (!$imagePath) {
                    throw new \RuntimeException('Gagal menyimpan foto repair.');
                }

                $storedFiles[] = $imagePath;

                $repair->images()->create([
                    'image_path' => $imagePath,
                    'image_type' => $validated['image_type'],
                ]);
            }
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($storedFiles);

            report($e);

            return back()->with(
                'error',
                'Gagal mengupload foto repair.'
            );
        }

        return back()->with(
            'success',
            count($storedFiles) . ' foto repair berhasil diupload.'
        );
    }

    public function destroy(InventoryRepair $repair, AssetRepairImage $image)
    {
        $repairImage = $repair->images()
            ->where('id', $image->id)
            ->firstOrFail();
        
        Storage::disk('public')->delete($repairImage->image_path);

        $repairImage->delete();
        
        return back()->with(
            'success',
            'Foto repair berhasil dihapus.'
        );
    }
}
