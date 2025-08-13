<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Services\FinancialCalculatorService;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Customer::count();
        $suppliersCount = Supplier::count();
        $reservationsCount = Invoice::count();

        // Sum total billed for all files
        $revenue = 0;

        // Efficient approach: load files with items and costs eager loaded
        $files = File::with(['items', 'costs', 'currency'])->get();

        foreach ($files as $file) {
            $calculator = new FinancialCalculatorService($file);
            $revenue += $calculator->totalBilled();
        }

        return view('dashboard', compact('clientsCount', 'suppliersCount', 'reservationsCount', 'revenue'));
    }
}
