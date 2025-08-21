<?php

namespace App\Enums\NotificationLog;

enum NotificationLogStatus: string
{
    case SENT = 'sent';
    case PENDING = 'pending';
    case FAILED = 'failed';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::SENT => 'Notification Sent',
            self::PENDING => 'Pending',
            self::FAILED => 'Failed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SENT => 'bg-green-100 text-blue-800',
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::FAILED => 'bg-red-100 text-red-800',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'M8.25 9.75h4.875a2.625 2.625 0 0 1 0 5.25H12M8.25 9.75 10.5 7.5M8.25 9.75 10.5 12',
            self::SENT => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
            self::FAILED => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636',
        };
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isSent(): bool
    {
        return $this === self::SENT;
    }

    public function hasFailed(): bool
    {
        return $this === self::FAILED;
    }
}