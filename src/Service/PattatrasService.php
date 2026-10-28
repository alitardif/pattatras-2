<?php

declare(strict_types=1);

namespace App\Service;

final class PattatrasService
{
    public const DEFAULT_START = 1;
    public const DEFAULT_END = 6457;

    private const REPLACEMENTS = [
        'pattatras' => 'Pattatras',
        'patte' => 'Patte',
        'tatras' => 'Tatras',
    ];

    public function transform(int $number): string
    {
        return $this->resolveValue($number, $this->resolveType($number));
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
            $type = $this->resolveType($number);
            $results[] = [
                'number' => $number,
                'value' => $this->resolveValue($number, $type),
                'type' => $type,
            ];
        }

        return $results;
    }

    private function resolveType(int $number): string
    {
        return match (true) {
            $number % 15 === 0 => 'pattatras',
            $number % 3 === 0 => 'patte',
            $number % 5 === 0 => 'tatras',
            default => 'number',
        };
    }

    private function resolveValue(int $number, string $type): string
    {
        return self::REPLACEMENTS[$type] ?? (string) $number;
    }
}
