<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\File;
use App\Models\FileCost;
use App\Models\FileItem;
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

        // get file sum
        $revenue = 0;
        $files = File::with(['items', 'costs', 'currency'])->get();

        foreach ($files as $file) {
            $calculator = new FinancialCalculatorService($file);
            $revenue += $calculator->totalBilled();
        }

        // Invoice, File, FileItem, FileCost
        $recentInvoices = Invoice::with('file.customer')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $recentFiles = File::with('customer')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $recentFileItems = FileItem::with('file.customer')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $recentFileCosts = FileCost::with('file.customer')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // merge all activities
        $recentActivities = collect()
            ->merge($recentInvoices)
            ->merge($recentFiles)
            ->merge($recentFileItems)
            ->merge($recentFileCosts)
            ->sortByDesc('updated_at')
            ->take(10);

        return view('dashboard', compact(
            'clientsCount',
            'suppliersCount',
            'reservationsCount',
            'revenue',
            'recentActivities'
        ));
    }
}
