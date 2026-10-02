<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetImage;
use Illuminate\Support\Facades\Storage;

class AssetImageController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
        ], [
            'images.required' => 'Pilih minimal satu gambar',
            'images.array' => 'Format gambar tidak di dukung',
            'images.mim' => 'Pilih minimal satu gambar',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP',
            'images.*.max' => 'Ukuran setiap foto maksimal 5 MB',
        ]);

        foreach ($validated['images'] as $image) {
            $image_path = $image->store('assets', 'public');

            AssetImage::create([
                'asset_id' => $asset->id,
                'outlet_id' => $asset->outlet_id,
                'image_path' => $image_path,
            ]);
        }

        return redirect()->route('assets.show', $asset)->with('success', 'Foto Asset berhasil diunggah.');
    }

    public function destroy(Asset $asset, AssetImage $image)
    {
        // Pastikan foto memang milik Asset yang sedang dibuka.
        $assetImage = $asset->images()->where('id', $image->id)->firstOrFail();

        Storage::disk('public')->delete($assetImage->image_path);

        $assetImage->delete();

        return redirect()->route('assets.show', $asset)->with('success', 'Foto Asset berhasil dihapus');
    }
}
