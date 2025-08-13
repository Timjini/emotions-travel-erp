<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\File;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Proforma;

class ReportController extends Controller
{
    public function index()
    {
        // Initial empty data or default report
        $initialReportData = File::where('company_id', Auth::user()->company_id)
            ->orderByDesc('created_at')
            ->paginate(25);
            
        return view('reports.index', compact('initialReportData'));
    }

    public function generate(Request $request)
    {
        $companyId = Auth::user()->company_id;
        
        $query = File::with(['file_costs'])
        ->where('company_id', $companyId);
            
        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        
        if ($request->filled('document_type')) {
            switch ($request->document_type) {
                case 'invoice':
                    $query->has('invoices');
                    break;
                case 'proforma':
                    $query->has('proformas');
                    break;
            }
        }
        
        // Apply sorting
        switch ($request->order_by) {
            case 'date_asc':
                $query->orderBy('start_date');
                break;
            case 'amount_asc':
                $query->orderBy('profit');
                break;
            case 'amount_desc':
                $query->orderByDesc('profit');
                break;
            default:
                $query->orderByDesc('start_date');
        }
        
    
    $reportData = $query->paginate(25);

    if ($request->ajax()) {
        // Do NOT call ->toArray() here
        return view('reports._table', compact('reportData'))->render();
    }
        
    return view('reports.index', compact('reportData'));
    }
}
