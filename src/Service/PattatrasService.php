<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ResultType;

final class PattatrasService
{
    public const DEFAULT_START = 1;
    public const DEFAULT_END = 6457;

    /**
     * Renvoie le mot associé au nombre, ou le nombre sous forme de texte.
     */
    public function transform(int $number): string
    {
        return $this->resolveType($number)->getValue($number);
    }

    /**
     * Construit les résultats de la plage inclusive.
     *
     * @return list<array{number: int, value: string, type: string}>
     *
     * @throws \InvalidArgumentException Si la borne de début dépasse la borne de fin.
     */
    public function generate(int $start = self::DEFAULT_START, int $end = self::DEFAULT_END): array
    {
        if ($start > $end) {
            throw new \InvalidArgumentException('La borne de début doit être inférieure ou égale à la borne de fin.');
        }

        $results = [];

        for ($number = $start; $number <= $end; ++$number) {
            $type = $this->resolveType($number);
            $results[] = [
                'number' => $number,
                'value' => $type->getValue($number),
                'type' => $type->value,
            ];
        }

        return $results;
    }

    /**
     * Retourne le type du mot associé au nombre saisi
     * Le multiple de 15 est prioritaire car il est aussi multiple de 3 et de 5.
     */
    private function resolveType(int $number): ResultType
    {
        return match (true) {
            $number % 15 === 0 => ResultType::Pattatras,
            $number % 3 === 0 => ResultType::Patte,
            $number % 5 === 0 => ResultType::Tatras,
            default => ResultType::Number,
        };
    }
}
