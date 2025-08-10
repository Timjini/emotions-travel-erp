<?php

namespace App\Enums;

enum CustomerCategory: string
{
    case GUIDE = 'guide';
    case HOTEL = 'hotel';
    case AGENCY = 'agency';
    case INDIVIDUAL = 'individual';
    case CORPORATE = 'corporate';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}