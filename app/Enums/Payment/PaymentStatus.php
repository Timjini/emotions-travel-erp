<?php

namespace App\Enums\Payment;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PARTIALLY_PAID = 'partially_paid';
    case FULLY_PAID = 'fully_paid';
    case FREE = 'free';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending Payment',
            self::PARTIALLY_PAID => 'Partially Paid',
            self::FULLY_PAID => 'Fully Paid',
            self::FREE => 'No Payment Required',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::PARTIALLY_PAID => 'bg-blue-100 text-blue-800',
            self::FULLY_PAID => 'bg-green-100 text-green-800',
            self::FREE => 'bg-purple-100 text-purple-800',
            self::CANCELLED => 'bg-red-100 text-red-800',
            self::REFUNDED => 'bg-gray-100 text-gray-800',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'M8.25 9.75h4.875a2.625 2.625 0 0 1 0 5.25H12M8.25 9.75 10.5 7.5M8.25 9.75 10.5 12',
            self::PARTIALLY_PAID => 'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
            self::FULLY_PAID => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
            self::FREE => 'M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z',
            self::CANCELLED => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636',
            self::REFUNDED => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99',
        };
    }

    public function isPaid(): bool
    {
        return match ($this) {
            self::FULLY_PAID, self::PARTIALLY_PAID => true,
            default => false,
        };
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isFree(): bool
    {
        return $this === self::FREE;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }
}
