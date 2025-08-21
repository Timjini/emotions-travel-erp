<?php
namespace App\Services\Invoices;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Services\Mailers\MailerInterface;

class InvoiceMailerService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendProforma(Invoice $invoice, string $recipient): void
    {
        $this->mailer->send($recipient, new InvoiceMail($invoice));
    }
}
