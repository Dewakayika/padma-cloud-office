<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyConverter
{
    public static function convert($amount, $from, $to)
    {
        $rate = self::getRate($from, $to);
        return $amount * $rate;
    }

    public static function getRate($from, $to)
    {
        $cacheKey = "currency_rate_{$from}_{$to}";
        return Cache::remember($cacheKey, 3600, function () use ($from, $to) {
            $apiKey = config('services.exchangerate.key');
            $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/pair/{$from}/{$to}");
            return $response->json('conversion_rate', 1); // fallback to 1 if API fails
        });
    }
}
