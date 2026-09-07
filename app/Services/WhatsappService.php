<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public static function send($phone, $message)
    {
        try{
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => env('WA_TOKEN')
                ])
                ->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => $message,
                ]);

                if (!$response->successful()) {

                    Log::error('WA Gagal', [
                        'phone' => $phone,
                        'response' => $response->body()
                    ]);

                    return false;
                }

                return $response->json();
        } catch (\Exception $e) {

            Log::error('WA Exception', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}