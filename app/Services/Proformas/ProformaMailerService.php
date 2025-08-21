<?php
namespace App\Services\Proformas;

use App\Mail\ProformaInvoiceMail;
use App\Models\Proforma;
use App\Services\Mailers\MailerInterface;

class ProformaMailerService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendProforma(Proforma $proforma, string $recipient): void
    {
        $this->mailer->send($recipient, new ProformaInvoiceMail($proforma));
    }
}
