<?php

namespace App\Http\Controllers;

use App\Models\WhatsappSession;
use App\Services\WhatsappService;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{

    public function webhook(Request $request)
    {
        $message = strtolower(trim($request->message));
        $sender = $request->sender;

        $session = WhatsappSession::firstOrCreate(
            ['phone' => $sender],
            ['counter' => 0]
        );

        if ($session->count >= 2) {
            WhatsappService::send($sender, "Silahkan hubungi admin untuk bantuan lebih lanjut.");
            return response()->json(['message' => 'Limit reached'], 200);
        }

        if (is_numeric($message)) {
            $reply = $this->handleMenu($message);

            WhatsappService::send($sender, $reply);
            $session->increment('count'); 
            return response()->json(['message' => 'Message processed'], 200);   
        }

        WhatsappService::send($sender, $this->menu());
        return response()->json(['message' => 'Menu sent'], 200);
    }

    public function menu()
    {
        return "*Pilih Keluhan Anda:*\n"
            ."1. Monitor tidak tampil\n"
            ."2. Tidak ada koneksi internet\n"
            ."3. Printer error\n"
            ."4. Aplikasi tidak bisa dibuka";
    }

    private function handleMenu($option)
    {
        return match($input) {
            '1' => "Tutorial Monitor: (Link ke tutorial monitor)",
            '2' => "Tutorial Internet: (Link ke tutorial internet)",
            '3' => "Tutorial Printer: (Link ke tutorial printer)",
            '4' => "Tutorial Aplikasi: (Link ke tutorial aplikasi)",
            default => "Pilihan tidak valid. Silakan pilih nomor yang sesuai dengan keluhan Anda"
        };
        // switch ($option) {
        //     case '1':
        //         return "Pastikan monitor terhubung dengan baik dan coba restart komputer Anda.";
        //     case '2':
        //         return "Periksa koneksi Wi-Fi atau kabel jaringan Anda, lalu coba lagi.";
        //     case '3':
        //         return "Coba matikan dan hidupkan kembali printer, pastikan juga tinta dan kertas tersedia.";
        //     case '4':
        //         return "Coba restart aplikasi atau komputer Anda. Jika masalah berlanjut, hubungi admin.";
        //     default:
        //         return "Pilihan tidak valid. Silakan pilih nomor yang sesuai dengan keluhan Anda.";
        // }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
