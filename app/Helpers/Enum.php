<?php

namespace App\Helpers;

trait EnumHelper
{
    public static function selectOptions(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = method_exists($case, 'label')
                ? $case->label()
                : $case->name;
        }

        return $options;
    }
}
