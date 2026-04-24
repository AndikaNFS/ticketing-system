<?php

namespace App\Http\Controllers;

use App\Models\WhatsappSession;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{

    // public function webhook(Request $request)
    // {

    //     // Hindari Loop
    //     if ($request->input('from_me') || $request->input('is_from_me')) {
    //         return response()->json(['status' => 'Ignored']);
    //     }

    //     if ($request->input('device') == 'YOUR_DEVICE_ID') {
    //         return response()->json(['status' => 'Ignored']);
    //     }

    //     if ($request->input('status') != 'received') {
    //         return response()->json(['status' => 'ignored']);
    //     }

        
        
    //     $message = strtolower(trim($request->input('message') ?? $request->input('text')));
    //     if (!$message) {
    //         return response()->json(['status' => 'No message']);
    //     }

    //     $sender = $request->input('sender');

    //     $session = WhatsappSession::firstOrCreate(
    //         ['phone' => $sender],
    //         ['count' => 0, 'state' => 'menu']
    //     );

    //     $state = $session->state ?? 'menu'; 

    //     // Reset counter jika sudah lebih dari 1 hari
    //     if ($session->updated_at->diffInDays(now()) >= 1) {
    //         $session->update(['count' => 0]);
    //     }

    //     // Batasi interaksi jika sudah mencapai batas
    //     if ($session->count >= 2) {
    //         WhatsappService::send($sender, "Silahkan hubungi admin untuk bantuan lebih lanjut.");
    //         return response()->json(['status' => 'Limit reached']);
    //     }


    //     switch ($state) {
    //         // state 'menu' untuk menampilkan menu utama
    //         case 'menu':
    //             WhatsappService::send($sender, $this->menu());
    //             $session->update(['state' => 'pilih_menu']);
    //             return response()->json(['status' => 'Menu sent']);
    //         // state 'pilih_menu' untuk menangani pilihan menu
    //         case 'pilih_menu':
    //             if (is_numeric($message)) {
    //                 $reply = $this->handleMenu($message);
    //                 WhatsappService::send($sender, $reply);

    //                 $session->increment('count');
    //                 $session->update(['state' => 'selesai']);
    //                 return response()->json(['status' => 'done']);
    //             }
    //             WhatsappService::send($sender, "Pilihan tidak valid. Silakan pilih nomor yang sesuai dengan keluhan Anda.");
    //             return response()->json(['status' => 'Invalid choice']);

    //             // state selesai untuk menandai sesi selesai, bisa direset atau dihapus
    //         case 'selesai':
    //             // WhatsappService::send($sender, "Terima kasih telah menggunakan layanan kami. Jika Anda  memiliki pertanyaan lain, silakan hubungi admin.");

    //             // reset sesi untuk memulai ulang interaksi
    //             if ($message == 'menu') {
    //                 $session->update(['state' => 'menu', 'count' => 0]);
    //                 WhatsappService::send($sender, $this->menu());
    //                 return response()->json(['status' => 'reset']);
    //             }


    //             return response()->json(['status' => 'Session completed']); 
    //     }
    //     return response()->json(['status' => 'unknown']);

    // }

    public function webhook(Request $request)
{
    if ($request->input('from_me') || $request->input('is_from_me')) {
        return response()->json(['status' => 'ignored']);
    }

    // if (!$request->input('message')) {
    //     return response()->json(['status' => 'ignored']);
    // }

    if($request->input('type') != 'text') {
        return response()->json(['status' => 'ignored']);
    }

    $sender  = $request->input('sender');
    $message = strtolower(trim($request->input('message')));

    
    // Hindari duplicate webhook
    $uniqueKey = $request->input('sender') . '-' . $request->input('message'). '-' . $request->input('timestamp');

    if (cache()->has($uniqueKey)) {
        return response()->json(['status' => 'duplicate']);
    }

    cache()->put($uniqueKey, true, 5);

    

    if (!$message) {
        return response()->json(['status' => 'no message']);
    }

    $session = WhatsappSession::firstOrCreate(
        ['phone' => $sender],
        ['count' => 0, 'state' => 'menu']
    );

    $state = $session->state ?? 'menu';

    if ($session->updated_at->diffInDays(now()) >= 1) {
        $session->update(['count' => 0]);
    }

    if ($session->count >= 2) {
        WhatsappService::send($sender, "Silahkan hubungi admin.");
        return response()->json(['status' => 'limit']);
    }

    // Anti dup0licate message
    if ($session->last_message == $message) {
        return response()->json(['status' => 'duplicate message']);
    }

    if ($session->state === 'selesai' && $message != 'menu') {
        // $session->update(['state' => 'menu', 'count' => 0]);
        // WhatsappService::send($sender,  "\n\nSesi sebelumnya telah selesai. Silakan ketik 'menu' untuk memulai kembali.");
        return response()->json(['status' => 'ignored']);
    }

    $session->update(['last_message' => $message]);

    // switch ($state) {

    //     case 'menu':
    //         // if (!is_numeric($message) && $message != 'menu') {
                
    //         //     }
    //             WhatsappService::send($sender, $this->menu());
    //             $session->update(['state' => 'pilih_menu']);
    //             return response()->json(['status' => 'menu']);

    //     case 'pilih_menu':
    //         if (is_numeric($message)) {
    //             $reply = $this->handleMenu($message);
    //             WhatsappService::send($sender, $reply);

    //             $session->increment('count');
    //             $session->update(['state' => 'selesai']);

    //             return response()->json(['status' => 'done']);
    //         }

    //         WhatsappService::send($sender, "Pilih angka yang valid.\n\n".$this->menu());
    //         return response()->json(['status' => 'invalid']);

    //     case 'selesai':
    //         if ($message == 'menu') {
    //             $session->update(['state' => 'menu', 'count' => 0]);
    //             WhatsappService::send($sender, $this->menu());
    //             return response()->json(['status' => 'reset']);
    //         }
    //         // $session->update(['state' => 'menu', 'count' => 0]);
    //         // WhatsappService::send($sender, $this->menu());

    //         return response()->json(['status' => 'idle']);
    // }

    

    // return response()->json(['status' => 'unknown']);

    switch ($state) {

        case 'menu':
            WhatsappService::send($sender, $this->menu());
            $session->update(['state' => 'pilih_menu']);
            return response()->json(['status' => 'menu']);

        case 'pilih_menu':
            if (is_numeric($message)) {

                $reply = $this->handleMenu($message);
                WhatsappService::send($sender, $reply);

                $session->increment('count');
                $session->update(['state' => 'selesai']);

                return response()->json(['status' => 'done']);
            }

            WhatsappService::send($sender, "Pilih angka yang valid.\n\n".$this->menu());
            return response()->json(['status' => 'invalid']);

        case 'selesai':

            if ($message == 'menu') {
                $session->update(['state' => 'menu', 'count' => 0]);
                WhatsappService::send($sender, $this->menu());

                return response()->json(['status' => 'reset']);
            }

            return response()->json(['status' => 'ended']);
    }
}


    public function menu()
    {
        return "*Pilih Keluhan Anda:*\n"
            ."1. Monitor tidak tampil\n"
            ."2. Tidak ada koneksi internet\n"
            ."3. Printer error\n"
            ."4. Aplikasi tidak bisa dibuka\n"
            ."5. Lainnya (Hubungi admin)";
    }

    private function handleMenu($input)
    {
        return match($input) {
            '1' => "Tutorial Monitor: (Link ke tutorial monitor)",
            '2' => "Tutorial Internet: (Link ke tutorial internet)",
            '3' => "Tutorial Printer: (Link ke tutorial printer)",
            '4' => "Tutorial Aplikasi: (Link ke tutorial aplikasi)",
            default => "Pilihan tidak valid. Silakan pilih nomor yang sesuai dengan keluhan Anda"
        };
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
