<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\Reports\StatsService;

class AnalyticsController extends Controller
{

    protected StatsService $stats;

    public function __construct(StatsService $stats)
    {
        $this->stats = $stats;
    }

    public function index()
    {
        $data = $this->stats->FileStats();

        $allFiles = File::with(['items', 'costs'])->get();
        $financials = $this->stats->CalculateFinances($allFiles);

        return view('reports.analytics.index', [
            'stats' => $data,
            'financials' => $financials,
        ]);
    }

}