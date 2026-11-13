<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HolidayService
{
    public static function getIndonesianHolidays($year)
    {
        return Cache::remember("libur-nasional-$year", now()->addDays(1), function () use ($year) {
            $response = Http::get("https://api-harilibur.vercel.app/api?year=$year");

            if ($response->successful()) {
                return collect($response->json())->pluck('holiday_date')->toArray();
            }

            return [];
        });
    }
}
