<?php

namespace App\Services\Reports;

use App\Models\Currency;
use App\Models\File;
use App\Services\ExchangeRateCalculator;
use Illuminate\Support\Facades\Log;

class StatsService
{
    protected ExchangeRateCalculator $currencyService;

    public function __construct(ExchangeRateCalculator $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Calculate total billed, total costs, profit, and margin for multiple files
     */
    public function calculateFinances($files)
    {
        if ($files->isEmpty()) {
            return [
                'total_billed' => 0,
                'total_costs' => 0,
                'profit' => 0,
                'profit_margin' => 0,
            ];
        }

        $totalBilled = 0;
        $totalCosts = 0;
        $companyCurrency = null;

        foreach ($files as $file) {
            $fileStats = $this->calculateFileFinances($file);

            $totalBilled += $fileStats['total_billed'];
            $totalCosts += $fileStats['total_costs'];
            $companyCurrency = $fileStats['company_currency'];
        }

        $profit = $totalBilled - $totalCosts;
        $profitMargin = $totalBilled > 0 ? ($profit / $totalBilled) * 100 : 0;

        return [
            'company_currency' => $companyCurrency,
            'total_billed' => round($totalBilled, 2),
            'total_costs' => round($totalCosts, 2),
            'profit' => round($profit, 2),
            'profit_margin' => round($profitMargin, 2),
        ];
    }

    /**
     * Calculate billed, costs, and profit for a single file
     */
    public function calculateFileFinances(File $file)
    {
        $companyCurrency = $file->company->setting->currency ?? Currency::first();

        // Total billed (loop over items and convert individually)
        $billed = 0;
        foreach ($file->items as $item) {
            $itemCurrency = $item->currency->code ?? $file->currency->code ?? 'USD';
            $exchangeRates = $this->currencyService->getFallbackRate($itemCurrency);
            $exchangedAmount = $exchangeRates[$companyCurrency->code] * $item->total_price;
            $billed += $exchangedAmount;
        }

        // Total costs (loop over costs and convert individually)
        $costs = 0;
        foreach ($file->costs as $costItem) {
            $baseCurrency = $costItem->baseCurrency->code ?? $file->currency->code ?? 'USD';
            $exchangeRates = $this->currencyService->getFallbackRate($baseCurrency);
            $exchangedAmount = $exchangeRates[$companyCurrency->code] * $costItem->total_price;
            $costs += $exchangedAmount;
        }

        $profit = $billed - $costs;
        $profitMargin = $billed > 0 ? ($profit / $billed) * 100 : 0;

        Log::info('Calculated file finances', [
            'file_id' => $file->id,
            'file_currency' => $file->currency->code ?? 'N/A',
            'company_currency' => $companyCurrency->code,
            'billed' => $billed,
            'costs' => $costs,
            'profit' => $profit,
            'profit_margin' => $profitMargin,
        ]);

        return [
            'file_id' => $file->id,
            'company_currency' => $companyCurrency->code,
            'total_billed' => round($billed, 2),
            'total_costs' => round($costs, 2),
            'profit' => round($profit, 2),
            'profit_margin' => round($profitMargin, 2),
        ];
    }

    /**
     * Basic file statistics by status
     */
    public function fileStats()
    {
        return [
            'total_bookings' => File::count(),
            'confirmed_bookings' => File::where('status', 'confirmed')->count(),
            'pending_bookings' => File::where('status', 'pending')->count(),
            'cancelled_bookings' => File::where('status', 'cancelled')->count(),
        ];
    }
}
