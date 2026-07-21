<?php

namespace App\Service;

final class PattatrasService
{
    public const DEFAULT_START = 1;
    public const DEFAULT_END = 6457;

    public function transform(int $number): string
    {
        $multipleOfThree = $number % 3 === 0;
        $multipleOfFive = $number % 5 === 0;

        if ($multipleOfThree && $multipleOfFive) {
            return 'Pattatras';
        }

        if ($multipleOfThree) {
            return 'Patte';
        }

        if ($multipleOfFive) {
            return 'Tatras';
        }

        return (string) $number;
    }

    /**
     * @return list<array{number: int, value: string, type: string}>
     */
    public function generate(int $start = self::DEFAULT_START, int $end = self::DEFAULT_END): array
    {
        if ($start > $end) {
            throw new \InvalidArgumentException('La borne de début doit être inférieure ou égale à la borne de fin.');
        }

        $results = [];

        for ($number = $start; $number <= $end; ++$number) {
            $value = $this->transform($number);
            $results[] = [
                'number' => $number,
                'value' => $value,
                'type' => $this->resolveType($value),
            ];
        }

        return $results;
    }

    private function resolveType(string $value): string
    {
        return match ($value) {
            'Pattatras' => 'pattatras',
            'Patte' => 'patte',
            'Tatras' => 'tatras',
            default => 'number',
        };
    }
}
