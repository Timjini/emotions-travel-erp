<?php

namespace App\Enums;

enum CustomerType: string
{
    case CLIENT = 'client';
    case SUPPLIER = 'supplier';
    case CLIENT_AND_SUPPLIER = 'client_and_supplier';
    case BANK = 'bank';
    case ACCOMMODATION = 'accommodation';
    case RESTAURANT = 'restaurant';
    case TOUR_OPERATOR = 'tour_operator';
    case TRANSPORT = 'transport';
    case OTHER = 'other';
    case INDIVIDUAL = 'individual';
    case BUSINESS = 'business';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::CLIENT => 'Client',
            self::SUPPLIER => 'Supplier',
            self::CLIENT_AND_SUPPLIER => 'Client & Supplier',
            self::BANK => 'Bank',
            self::ACCOMMODATION => 'Accommodation',
            self::RESTAURANT => 'Restaurant',
            self::TOUR_OPERATOR => 'Tour Operator',
            self::TRANSPORT => 'Transport',
            self::OTHER => 'Other',
            self::INDIVIDUAL => 'Individual',
            self::BUSINESS => 'Business',
        };
    }
}
