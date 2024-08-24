<?php

namespace App\Enums\Traits;

trait HasArrayValues
{
    public static function toArrayValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
