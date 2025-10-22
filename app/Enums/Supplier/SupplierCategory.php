<?php

namespace App\Enums\Supplier;

enum SupplierCategory: string
{
    case GUIDE = 'guide';
    case HOTEL = 'hotel';
    case AGENCY = 'agency';
    case INDIVIDUAL = 'individual';
    case CORPORATE = 'corporate';
    case TOUR_OPERATOR = 'tour operator';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::GUIDE => 'Guide',
            self::HOTEL => 'Hotel',
            self::AGENCY => 'Agency',
            self::INDIVIDUAL => 'Individual',
            self::CORPORATE => 'Corporate',
            self::TOUR_OPERATOR => 'Tour Operator',
        };
    }
}
