<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ExchangeRateCalculator
{
    /**
     * Convert currency using ExchangeRate-API with 48-hour caching.
     *
     * @param string $baseCurrency       The currency code to convert from (e.g. "USD").
     * @param string $originalCurrency   The currency code to convert to (e.g. "EUR").
     * @return float|null
     */
    public function convertCurrency($baseCurrency, $originalCurrency)
    {
        try {
            $cacheKey = "exchange_rates_{$baseCurrency}";
            $exchangeRates = Cache::remember($cacheKey, now()->addHours(48), function () use ($baseCurrency) {
                $apiKey = env('EXCHANGE_API_KEY');

                $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}");

                if ($response->successful()) {
                    return $response->json()['conversion_rates'] ?? [];
                }

                Log::error('Exchange rate API call failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [];
            });

            return $exchangeRates[$originalCurrency] ?? null;
        } catch (\Exception $e) {
            Log::error('Exchange rate conversion failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }
}
