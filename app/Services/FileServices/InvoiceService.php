<?php
namespace App\Services\FileServices;

use App\Models\Invoice;
use App\Models\Proforma;

class InvoiceService
{
    public function createFromProforma(Proforma $proforma): Invoice
    {
        $invoiceNumber = 'INV-' . now()->format('ymdHis');

        $invoice = Invoice::create([
            'file_id' => $proforma->file_id,
            'proforma_id' => $proforma->id,
            'invoice_number' => $invoiceNumber,
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'total_amount' => $proforma->total_amount,
            'currency_id' => $proforma->currency_id,
            'status' => 'unpaid',
        ]);

        foreach ($proforma->file->items as $item) {
            $invoice->items()->create($item->only([
                'service_name', 'description', 'quantity', 'unit_price', 'total_price', 'currency_id'
            ]));
        }

        $proforma->update(['status' => Proforma::STATUS_CONVERTED]);

        return $invoice;
    }
}
