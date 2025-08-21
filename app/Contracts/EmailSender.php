<?php 

namespace App\Contracts;

interface EmailSender
{
    public function send(string $to, string $subject, string $body, array $attachments = []): void;
}
