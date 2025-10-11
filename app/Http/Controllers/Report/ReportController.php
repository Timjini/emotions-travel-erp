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
        $companyId = Auth::user()->company_id;

        // Initial report (first page)
        $reportData = File::with(['customer', 'owner', 'destination', 'proformas', 'invoices'])
            ->where('company_id', $companyId)
            ->orderByDesc('start_date')
            ->paginate(25);

        return view('reports.index', compact('reportData'));
    }

    public function generate(Request $request)
    {
        $companyId = Auth::user()->company_id;
    
        switch ($request->document_type) {
            case 'invoice':
                $query = Invoice::with(['file.customer', 'file.owner', 'file.destination'])
                    ->whereHas('file', fn($q) => $q->where('company_id', $companyId));
                $dateColumn = 'created_at';
                break;
    
            case 'proforma':
                $query = Proforma::with(['file.customer', 'file.owner', 'file.destination'])
                    ->whereHas('file', fn($q) => $q->where('company_id', $companyId));
                $dateColumn = 'created_at';
                break;
    
            default: // file
                $query = File::with(['customer', 'owner', 'destination', 'proformas', 'invoices'])
                    ->where('company_id', $companyId);
                $dateColumn = 'start_date';
        }
    
        // Filters
        if ($request->filled('start_date')) {
            $query->whereDate($dateColumn, '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate($dateColumn, '<=', $request->end_date);
        }
    
        // Sorting (use $dateColumn instead of hardcoding start_date)
        switch ($request->order_by) {
            case 'date_asc':
                $query->orderBy($dateColumn);
                break;
            case 'date_desc':
                $query->orderByDesc($dateColumn);
                break;
            case 'amount_asc':
                $query->orderBy('profit'); 
                break;
            case 'amount_desc':
                $query->orderByDesc('profit');
                break;
            default:
                $query->orderByDesc($dateColumn);
        }
    
       $reportData = $query->paginate(25);

        $reportData->getCollection()->transform(function ($item) use ($request) {
            if ($request->document_type === 'invoice') {
                return [
                    'id' => $item->id,
                    'number' => $item->invoice_number,
                    'date' => $item->issue_date,
                    'type' => 'Invoice',
                    'customer' => $item->file?->customer?->name,
                    'owner' => $item->file?->owner?->name,
                    'destination' => $item->file?->destination?->name,
                    'amount' => $item->total ?? null,
                ];
            } elseif ($request->document_type === 'proforma') {
                return [
                    'id' => $item->id,
                    'number' => $item->proforma_number,
                    'date' => $item->issue_date,
                    'type' => 'Proforma',
                    'customer' => $item->file?->customer?->name,
                    'owner' => $item->file?->owner?->name,
                    'destination' => $item->file?->destination?->name,
                    'amount' => $item->total ?? null,
                ];
            } else {
                return [
                    'id' => $item->id,
                    'number' => $item->file_number,
                    'date' => $item->start_date,
                    'type' => 'File',
                    'customer' => $item->customer?->name,
                    'owner' => $item->owner?->name,
                    'destination' => $item->destination?->name,
                    'amount' => $item->profit ?? null,
                ];
            }
        });
    
        if ($request->ajax()) {
            return view('reports._table', compact('reportData'))->render();
        }
    
        return view('reports.index', compact('reportData'));
    }

}

