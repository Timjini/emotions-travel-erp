<?php

namespace Tests\Unit\Services;

use Tests\TestCase; // ← This is the correct one!
use App\Services\ExchangeRateCalculator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExchangeRateCalculatorTest extends TestCase
{
    private ExchangeRateCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp(); // This initializes Laravel application
        $this->calculator = new ExchangeRateCalculator();
    }

    /** @test */
    public function it_returns_exchange_rate_successfully()
    {
        Http::fake([
            'v6.exchangerate-api.com/v6/*/latest/USD' => Http::response([
                'result' => 'success',
                'conversion_rates' => [
                    'USD' => 1.0,
                    'EUR' => 0.85,
                    'GBP' => 0.73,
                ]
            ], 200)
        ]);

        $result = $this->calculator->convertCurrency('USD', 'EUR');

        $this->assertEquals(0.85, $result);
    }

    /** @test */
    public function it_returns_null_for_invalid_currency()
    {
        Http::fake([
            'v6.exchangerate-api.com/v6/*/latest/USD' => Http::response([
                'result' => 'success',
                'conversion_rates' => [
                    'USD' => 1.0,
                    'EUR' => 0.85,
                ]
            ], 200)
        ]);

        $result = $this->calculator->convertCurrency('USD', 'INVALID');

        $this->assertNull($result);
    }

    /** @test */
    public function it_handles_api_failure_gracefully()
    {
        Http::fake([
            'v6.exchangerate-api.com/v6/*/latest/USD' => Http::response([], 500)
        ]);

        // Log::shouldReceive('error') will work now with Laravel's TestCase
        Log::shouldReceive('error')
            ->once()
            ->with('Exchange rate API call failed', \Mockery::type('array'));

        $result = $this->calculator->convertCurrency('USD', 'EUR');

        $this->assertNull($result);
    }

    /** @test */
    public function it_uses_cache_to_store_exchange_rates()
    {
        $mockRates = [
            'USD' => 1.0,
            'EUR' => 0.85,
            'GBP' => 0.73,
        ];

        Http::fake([
            'v6.exchangerate-api.com/v6/*/latest/USD' => Http::response([
                'result' => 'success',
                'conversion_rates' => $mockRates
            ], 200)
        ]);

        // First call - should hit API and cache
        $result1 = $this->calculator->convertCurrency('USD', 'EUR');
        
        // Second call - should use cache
        $result2 = $this->calculator->convertCurrency('USD', 'EUR');

        $this->assertEquals(0.85, $result1);
        $this->assertEquals(0.85, $result2);

        // Verify cache was used
        $this->assertTrue(Cache::has('exchange_rates_USD'));
        $this->assertEquals($mockRates, Cache::get('exchange_rates_USD'));
    }

    /** @test */
    public function it_handles_exception_gracefully()
    {
        Http::fake(function () {
            throw new \Exception('Network error');
        });

        Log::shouldReceive('error')
            ->once()
            ->with('Exchange rate conversion failed', \Mockery::type('array'));

        $result = $this->calculator->convertCurrency('USD', 'EUR');

        $this->assertNull($result);
    }
}