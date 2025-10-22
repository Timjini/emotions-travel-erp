<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Proforma;
use Illuminate\Support\Facades\DB;

class ShowReports extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;
    public $document_type = '';
    public $order_by = 'date_desc';

    protected $paginationTheme = 'tailwind';
    protected $queryString = ['document_type', 'order_by', 'start_date', 'end_date'];

    public function updating($property)
    {
        if (in_array($property, ['start_date', 'end_date', 'document_type', 'order_by'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['start_date', 'end_date', 'document_type', 'order_by']);
        $this->order_by = 'date_desc';
    }

    public function getReportDataProperty()
    {
        $companyId = Auth::user()->company_id;
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        switch ($this->document_type) {
            case 'files':
                return $this->getFilesData($companyId, $startDate, $endDate);

            case 'proformas':
                return $this->getProformasData($companyId, $startDate, $endDate);

            case 'invoices':
                return $this->getInvoicesData($companyId, $startDate, $endDate);
            default:
                return $this->getInvoicesData($companyId, $startDate, $endDate);
        }
    }

    private function getInvoicesData($companyId, $startDate, $endDate)
    {
        $query = DB::table('invoices')
            ->select([
                'invoices.id',
                'invoices.invoice_number as number',
                'invoices.issue_date',
                'invoices.created_at',
                'invoices.file_id',
                DB::raw("'invoice' as report_type"),
                DB::raw("NULL as file_number"),
                DB::raw("NULL as proforma_number"),
                DB::raw("NULL as start_date")
            ])
            ->where('invoices.company_id', $companyId)
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('invoices.issue_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('invoices.issue_date', '<=', $endDate);
            });

        return $this->applyOrderBy($query)->paginate(25);
    }

    private function getFilesData($companyId, $startDate, $endDate)
    {
        $query = DB::table('files')
        ->join('customers', 'customers.id', '=', 'files.customer_id')
        ->join('destinations', 'destinations.id', '=', 'files.destination_id')
        ->select([
            'files.id',
            'files.reference as number',
            'files.start_date',
            'files.created_at',
            'files.id as file_id',
            'files.customer_id',
            'customers.name as customer_name',
            'customers.email as customer_email',
            'files.destination_id',
            'destinations.name as destination_name',
            DB::raw("'file' as report_type"),
            DB::raw("NULL as invoice_number"),
            DB::raw("NULL as proforma_number"),
            DB::raw("NULL as issue_date")
        ])
        ->where('files.company_id', $companyId)
        ->when($startDate, fn($q) => $q->whereDate('files.start_date', '>=', $startDate))
        ->when($endDate, fn($q) => $q->whereDate('files.start_date', '<=', $endDate));

         return $this->applyOrderBy($query)->paginate(25);
    }

    private function getProformasData($companyId, $startDate, $endDate)
    {
        $query = DB::table('proformas')
            ->select([
                'proformas.id',
                'proformas.proforma_number as number',
                'proformas.issue_date',
                'proformas.created_at',
                'proformas.file_id',
                DB::raw("'proforma' as report_type"),
                DB::raw("NULL as invoice_number"),
                DB::raw("NULL as file_number"),
                DB::raw("NULL as start_date")
            ])
            ->where('proformas.company_id', $companyId)
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('proformas.issue_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('proformas.issue_date', '<=', $endDate);
            });

        return $this->applyOrderBy($query)->paginate(25);
    }

    private function applyOrderBy($query)
    {
        switch ($this->document_type) {
            case 'files':
                $dateExpr = 'COALESCE(files.start_date, files.created_at)';
                $table = 'files';
                break;
    
            case 'proformas':
                $dateExpr = 'COALESCE(proformas.issue_date, proformas.created_at)';
                $table = 'proformas';
                break;
    
            case 'invoices':
            default:
                $dateExpr = 'COALESCE(invoices.issue_date, invoices.created_at)';
                $table = 'invoices';
                break;
        }
    
        switch ($this->order_by) {
            case 'date_asc':
                return $query->orderByRaw("$dateExpr ASC");
    
            case 'total_desc':
                return $query->orderBy("{$table}.total", 'DESC');
    
            case 'total_asc':
                return $query->orderBy("{$table}.total", 'ASC');
    
            case 'date_desc':
            default:
                return $query->orderByRaw("$dateExpr DESC");
        }
    }

    public function render()
    {
        return view('livewire.show-reports', [
            'reportData' => $this->reportData,
        ]);
    }
}
