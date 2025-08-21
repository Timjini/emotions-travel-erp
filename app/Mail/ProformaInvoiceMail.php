<?php
namespace App\Mail;

use App\Models\Proforma;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProformaInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Proforma $proforma;

    public function __construct(Proforma $proforma)
    {
        $this->proforma = $proforma;
    }

    public function build()
    {
        return $this->subject('Proforma')
            ->view('emails.proformas.template')
            ->with([
                'proforma' => $this->proforma,
            ]);
    }
}
