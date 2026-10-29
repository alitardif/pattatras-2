<?php

declare(strict_types=1);

namespace App\Enum;

enum ResultType: string
{
    case Number = 'number';
    case Patte = 'patte';
    case Tatras = 'tatras';
    case Pattatras = 'pattatras';

    /**
     * Renvoie le libellé du type, ou le nombre pour le type Number.
     */
    public function getValue(int $number): string
    {
        return match ($this) {
            self::Number => (string) $number,
            self::Patte => 'Patte',
            self::Tatras => 'Tatras',
            self::Pattatras => 'Pattatras',
        };
    }
}
