<?php
namespace App\Services\Mailers;

use Illuminate\Mail\Mailable;

interface MailerInterface
{
    public function send(string $to, Mailable $mailable): void;
}
