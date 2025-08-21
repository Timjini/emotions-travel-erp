<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invoice $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        // Generate PDF from your Blade view
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $this->invoice
        ]);

        return $this->subject('Invoice #' . $this->invoice->invoice_number)
            ->view('emails.invoices.template')
            ->with([
                'invoice' => $this->invoice,
            ])
            ->attachData($pdf->output(), 'Invoice-' . $this->invoice->invoice_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}