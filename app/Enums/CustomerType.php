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
}