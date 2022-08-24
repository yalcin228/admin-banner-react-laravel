<?php

namespace App\Traits;

trait EnumParser
{
    /**
     * @return array
     */
    public static function toArray(): array
    {
        $values = [];

        foreach (self::cases() as $enum) {
            $values[] = $enum->value ?? $enum->name;
        }

        return $values;
    }

    /**
     * @param string $separator
     * @return string
     */
    public static function toString(string $separator = ', '): string
    {
        return implode($separator, self::toArray());
    }
}
