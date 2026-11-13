<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetImage;
use App\Models\Outlet;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssetImageController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'image_type' => ['nullable', 'in:physical, serial_number'],
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
                'image_type' => $request->input['image_type'] ?? 'physical',
            ]);
        }

        return redirect()->route('assets.show', $asset)->with('success', 'Asset photo uploaded successfully.');
    }

    
    public function importZip(Request $request, Outlet $outlet)
    {
        $request->validate([
            'zip_file' => [
                'required',
                'file',
                'mimes:zip',
                'max:102400', // Maksimal 100 MB
            ],
        ]);

        $zip = new ZipArchive();
        $zipPath = $request->file('zip_file')->getRealPath();

        if ($zip->open($zipPath) !== true) {
            return back()->with('error', 'File ZIP tidak dapat dibuka.');
        }

        $success = 0;
        $failed = [];
        $storedFiles = [];

        // Batas keamanan file
        $maxImageSize = 5 * 1024 * 1024; // Maksimal 5 MB per foto
        $maxTotalSize = 200 * 1024 * 1024; // Maksimal 200 MB ukuran ekstrak

        try {
            // Periksa total ukuran file di dalam ZIP
            $totalSize = 0;

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);

                if ($stat && !str_ends_with($zip->getNameIndex($i), '/')) {
                    $totalSize += $stat['size'] ?? 0;
                }
            }

            if ($totalSize > $maxTotalSize) {
                return back()->with(
                    'error',
                    'Total ukuran foto setelah diekstrak melebihi batas 200 MB.'
                );
            }

            DB::beginTransaction();

            for ($i = 0; $i < $zip->numFiles; $i++) {

                $originalName = $zip->getNameIndex($i);

                // Abaikan folder
                if (!$originalName || str_ends_with($originalName, '/')) {
                    continue;
                }

                // Ambil nama file saja
                $filename = basename($originalName);

                // Ambil informasi ukuran file
                $stat = $zip->statIndex($i);
                $fileSize = $stat['size'] ?? 0;

                if ($fileSize <= 0 || $fileSize > $maxImageSize) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => 'Ukuran foto kosong atau melebihi 5 MB.',
                    ];
                    continue;
                }

                // Validasi filename dan extension
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => 'Format file tidak didukung.',
                    ];
                    continue;
                }

                /*
                * Format yang diterima:
                *
                * 261108-003-05-001.jpg
                * 261108-003-05-001_01.jpg
                * 261108-003-05-001_02.jpg
                * 261108-003-05-001_SN.jpg
                * 261108-003-05-001_SN_01.jpg
                * 261108-003-05-001_SN_02.jpg
                */

                if (!preg_match(
                    '/^(?<asset_number>\d{6}\d{2}\d{2}\d{3})(?<serial>_SN)?(?:_\d+)?\.(?:jpg|jpeg|png|webp)$/i',
                    $filename,
                    $matches
                )) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => 'Format filename tidak sesuai.',
                    ];
                    continue;
                }

                // Ambil Asset Number dari filename
                $assetNumber = $matches['asset_number'];

                // Tentukan jenis foto otomatis
                $imageType = !empty($matches['serial'])
                    ? 'serial_number'
                    : 'physical';

                // Cari asset hanya pada outlet yang sedang dibuka
                $asset = Asset::where('asset_number', $assetNumber)
                    ->where('outlet_id', $outlet->id)
                    ->first();

                if (!$asset) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => "Asset Number {$assetNumber} tidak ditemukan pada outlet ini.",
                    ];
                    continue;
                }

                // Baca isi gambar dari ZIP
                $imageContent = $zip->getFromIndex($i);

                if ($imageContent === false) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => 'Gagal membaca isi foto.',
                    ];
                    continue;
                }

                // Pastikan isi file benar-benar gambar
                $imageInfo = @getimagesizefromstring($imageContent);

                if (!$imageInfo) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => 'Isi file bukan gambar yang valid.',
                    ];
                    continue;
                }

                // Cocokkan extension dengan MIME gambar
                $allowedMimeTypes = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'webp' => 'image/webp',
                ];

                if (
                    !isset($allowedMimeTypes[$extension]) ||
                    $imageInfo['mime'] !== $allowedMimeTypes[$extension]
                ) {
                    $failed[] = [
                        'file' => $filename,
                        'reason' => 'Extension dan tipe gambar tidak sesuai.',
                    ];
                    continue;
                }

                // Simpan foto dengan nama unik
                $newFilename = Str::uuid() . '.' . $extension;

                $imagePath = 'assets/' . $newFilename;

                $stored = Storage::disk('public')->put(
                    $imagePath,
                    $imageContent
                );

                if (!$stored) {
                    throw new \RuntimeException(
                        "Gagal menyimpan foto: {$filename}"
                    );
                }

                // Catat file untuk keperluan cleanup jika transaksi gagal
                $storedFiles[] = $imagePath;

                // Simpan informasi foto ke database
                AssetImage::create([
                    'asset_id' => $asset->id,
                    'outlet_id' => $asset->outlet_id,
                    'image_path' => $imagePath,
                    'image_type' => $imageType,
                ]);

                $success++;
            }

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();

            // Hapus file jika transaksi database gagal
            Storage::disk('public')->delete($storedFiles);

            report($e);

            return back()->with(
                'error',
                'Import gagal. Tidak ada data foto yang disimpan.'
            );

        } finally {
            $zip->close();
        }

        return back()->with([
            'success' => "{$success} foto berhasil diimport.",
            'import_failed' => $failed,
        ]);
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
