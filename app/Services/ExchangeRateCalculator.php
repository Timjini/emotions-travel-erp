<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

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
                return $this->fetchExchangeRates($baseCurrency);
            });
    
            // If we have rates from API, return the specific rate
            if (!empty($exchangeRates) && isset($exchangeRates[$originalCurrency])) {
                return $exchangeRates[$originalCurrency];
            }
    
            // Fallback to config rates if API fails or currency not found
            $fallBackCurrency = $this->getFallbackRate($baseCurrency);

            return $fallBackCurrency[$originalCurrency];
    
        } catch (\Exception $e) {
            Log::error('Exchange rate conversion failed', [
                'error' => $e->getMessage(),
                'base_currency' => $baseCurrency,
                'target_currency' => $originalCurrency,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
    
    /**
     * Fetch exchange rates from API with multiple fallback strategies
     */
    private function fetchExchangeRates($baseCurrency)
    {
        $apiKey = env('EXCHANGE_API_KEY');
        
        // Strategy 1: Primary API
        try {
            $response = Http::timeout(10)->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}");
    
            Log::error('ExchangeRate-API Response Details', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'headers' => $response->headers(),
                'body_preview' => substr($response->body(), 0, 500),
            ]);
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['conversion_rates']) && !empty($data['conversion_rates'])) {
                    Log::info('Exchange rates successfully fetched from primary API', [
                        'base_currency' => $baseCurrency,
                        'rates_count' => count($data['conversion_rates'])
                    ]);
                    return $data['conversion_rates'];
                }
            }
            
            Log::warning('Primary exchange rate API returned unsuccessful response', [
                'status' => $response->status(),
                'base_currency' => $baseCurrency,
            ]);
        } catch (\Exception $e) {
            Log::warning('Primary exchange rate API call failed', [
                'error' => $e->getMessage(),
                'base_currency' => $baseCurrency,
            ]);
        }
    
        // Strategy 2: Check cache for recent successful rates (different base currency)
        $fallbackRates = $this->getCachedFallbackRates();
        if (!empty($fallbackRates)) {
            Log::info('Using cached fallback exchange rates');
            return $fallbackRates;
        }
    
        // Strategy 3: Return empty to trigger config fallback
        Log::warning('All exchange rate fetch strategies failed, using config fallback');
        return [];
    }
    
    /**
     * Get fallback rate from config with validation
     */
    private function getFallbackRate($currency)
    {
        $fallbackRates = [
            'MAD' => [
                'USD' => 0.10,
                'EUR' => 0.092,
                'GBP' => 0.081,
                'PLN' => 0.42,
                'MAD' => 1,
            ],
            'USD' => [
                'MAD' => 10,
                'EUR' => 0.92,
                'GBP' => 0.81,
                'PLN' => 4.2,
                'USD' => 1,
            ],
            'EUR' => [
                'MAD' => 10.8,
                'USD' => 1.08,
                'GBP' => 0.87,
                'PLN' => 4.5,
                'EUR' => 1,
            ],
            'GBP' => [
                'MAD' => 12.3,
                'USD' => 1.23,
                'EUR' => 1.15,
                'PLN' => 5.2,
                'GBP' => 1,
            ],
            'PLN' => [
                'MAD' => 2.4,
                'USD' => 0.24,
                'EUR' => 0.22,
                'GBP' => 0.19,
                'PLN' => 1,
            ],
        ];
        
        if (isset($fallbackRates[$currency])) {
            Log::info('Using fallback exchange rate from config', [
                'currency' => $currency,
                'rate' => $fallbackRates[$currency]
            ]);
            return $fallbackRates[$currency];
        }
    
        Log::error('Fallback exchange rate not found for currency', [
            'currency' => $currency,
            'available_currencies' => array_keys($fallbackRates)
        ]);
    
        return null;
    }
    
    /**
     * Get any cached exchange rates as fallback
     */
    private function getCachedFallbackRates()
    {
        // Look for any recently cached exchange rates
        $cacheKeys = [
            "exchange_rates_USD",
            "exchange_rates_EUR", 
            "exchange_rates_GBP"
        ];
    
        foreach ($cacheKeys as $cacheKey) {
            $cachedRates = Cache::get($cacheKey);
            if (!empty($cachedRates)) {
                return $cachedRates;
            }
        }
    
        return [];
    }
}
