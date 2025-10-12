<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\Reports\StatsService;

class AnalyticsController extends Controller
{

    public function index()
    {
        $statsService = new StatsService();
        $stats = $statsService->FileStats();

        $allFiles = File::with(['items', 'costs'])->get();
        $financials = $statsService->CalculateFinances($allFiles);

        return view('reports.analytics.index', [
            'stats' => $stats,
            'financials' => $financials,
        ]);
    }

}