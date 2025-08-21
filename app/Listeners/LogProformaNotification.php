<?php
namespace App\Listeners;

use App\Enums\NotificationLog\NotificationLogChannel;
use App\Enums\NotificationLog\NotificationLogStatus;
use App\Events\ProformaSendFailed;
use App\Events\ProformaSent;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class LogProformaNotification
{
    public function handleProformaSent(ProformaSent $event)
    {
        try {
            Log::info("-----> trying to create", ['notifiable_id'=> $event]);
            NotificationLog::create([
                'id' => Str::uuid(),
                'channel' => NotificationLogChannel::EMAIL,
                'notifiable_id' => $event->proforma->id,
                'notifiable_type' => get_class($event->proforma),
                'sender_id' => $event->sender->id,
                'receiver_name' => $event->proforma->file->customer->name ?? 'Unknown',
                'receiver_email' => $event->proforma->file->customer->email ?? null,
                'subject' => 'Proforma #' . $event->proforma->id,
                'message' => 'Proforma document sent successfully',
                'status' => NotificationLogStatus::SENT,
                'sent_at' => now(),
            ]);

            Log::info('Proforma sent log created successfully', [
                'proforma_id' => $event->proforma->id,
                'receiver' => $event->proforma->file->customer->email ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log Proforma sent event', [
                'proforma_id' => $event->proforma->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    public function handleProformaSendFailed(ProformaSendFailed $event)
    {
        try {
            NotificationLog::create([
                'id' => Str::uuid(),
                'channel' => NotificationLogChannel::EMAIL,
                'notifiable_id' => $event->proforma->id ?? null,
                'notifiable_type' => get_class($event->proforma),
                'sender_id' => $event->sender->id ?? null,
                'receiver_name' => $event->proforma->file->customer->name ?? 'Unknown',
                'receiver_email' => $event->proforma->file->customer->email ?? null,
                'subject' => 'Proforma #' . ($event->proforma->id ?? 'N/A'),
                'message' => $event->errorMessage ?? 'Unknown error',
                'status' => NotificationLogStatus::FAILED,
            ]);

            Log::warning('Proforma send failed log created', [
                'proforma_id' => $event->proforma->id ?? null,
                'error' => $event->errorMessage ?? 'No message',
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log Proforma send failed event', [
                'proforma_id' => $event->proforma->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    public function subscribe($events)
    {
        return [
            ProformaSent::class => 'handleProformaSent',
            ProformaSendFailed::class => 'handleProformaSendFailed',
        ];
    }
}
