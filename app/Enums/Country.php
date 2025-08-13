<?php

namespace App\Enums;

use App\Helpers\EnumHelper;

enum Country: string
{
    use EnumHelper;

    case AW = 'AW';
    case AF = 'AF';
    case AO = 'AO';

    public function label(): string
    {
        return config('countries')[$this->value] ?? $this->value;
    }

    public static function options(): array
    {
        return array_map(
            fn (Country $country) => $country->label(),
            self::cases()
        );
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromLabel(string $label): ?self
    {
        $countries = config('countries');
        $code = array_search($label, $countries);

        return $code ? self::from($code) : null;
    }
}
