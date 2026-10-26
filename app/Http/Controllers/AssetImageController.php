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
            'images.required' => 'Please select at least one image.',
            'images.array' => 'Unsupported image format.',
            'images.mim' => 'Please select at least one image.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Images must be JPG, JPEG, PNG, or WEBP.',
            'images.*.max' => 'Each photo must not exceed 5 MB.',
        ]);

        foreach ($validated['images'] as $image) {
            $image_path = $image->store('assets', 'public');

            AssetImage::create([
                'asset_id' => $asset->id,
                'outlet_id' => $asset->outlet_id,
                'image_path' => $image_path,
            ]);
        }

        return redirect()->route('assets.show', $asset)->with('success', 'Asset photo uploaded successfully.');
    }

    public function destroy(Asset $asset, AssetImage $image)
    {
        // Ensure the photo belongs to the asset currently being viewed.
        $assetImage = $asset->images()->where('id', $image->id)->firstOrFail();

        Storage::disk('public')->delete($assetImage->image_path);

        $assetImage->delete();

        return redirect()->route('assets.show', $asset)->with('success', 'Asset photo deleted successfully.');
    }
}
