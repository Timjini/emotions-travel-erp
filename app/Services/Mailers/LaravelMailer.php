<?php
namespace App\Services\Mailers;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class LaravelMailer implements MailerInterface
{
    public function send(string $to, Mailable $mailable): void
    {
        Mail::to($to)->send($mailable);
    }
}
