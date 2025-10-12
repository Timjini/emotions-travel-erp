<?php
namespace App\Services\Reports;

use App\Models\Currency;
use App\Models\File;
use App\Services\ExchangeRateCalculator;
use Illuminate\Support\Facades\Log;

class StatsService 
{
    public function CalculateFinances($files)
    {
        $totalBilled = $files->sum(function ($file) {
            $currencyService = new ExchangeRateCalculator();
            $exchangeRate = $currencyService->getFallbackRate($file->currency->code ?? Currency::first()->code);
            $defaultCurrency = $file->company->setting->currency;
            Log::info('Converted currency', [
                'currency' => $exchangeRate,
                'company_currency' => $defaultCurrency,
                'file_currency' => $file->currency->code,
                'target_rate'=> $exchangeRate[$file->currency->code],
            ]);
            return $file->items->sum('total_price') * $exchangeRate[$file->currency->code];
        });

        $totalCosts = $files->sum(function ($file) {
            return $file->costs->sum('total_price');
        });

        $profit = $totalBilled - $totalCosts;
        $profitMargin = $totalBilled > 0 ? ($profit / $totalBilled) * 100 : 0;

        return [
            'total_billed' => $totalBilled,
            'total_costs' => $totalCosts,
            'profit' => $profit,
            'profit_margin' => $profitMargin,
        ];
    }

    public function FileStats()
    {
        return [
            'total_bookings' => File::count(),
            'confirmed_bookings' => File::where('status', 'confirmed')->count(),
            'pending_bookings' => File::where('status', 'pending')->count(),
            'cancelled_bookings' => File::where('status', 'cancelled')->count(),
        ];
    }
}