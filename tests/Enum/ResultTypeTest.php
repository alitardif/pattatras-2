<?php

declare(strict_types=1);

namespace App\Tests\Enum;

use App\Enum\ResultType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ResultTypeTest extends TestCase
{
    #[DataProvider('resultTypes')]
    public function testGetValueAndCategory(
        ResultType $type,
        int $number,
        string $expectedValue,
        string $expectedCategory,
    ): void {
        self::assertSame($expectedValue, $type->getValue($number));
        self::assertSame($expectedCategory, $type->value);
    }

    /** @return iterable<string, array{ResultType, int, string, string}> */
    public static function resultTypes(): iterable
    {
        yield 'nombre' => [ResultType::Number, 7, '7', 'number'];
        yield 'patte' => [ResultType::Patte, 3, 'Patte', 'patte'];
        yield 'tatras' => [ResultType::Tatras, 5, 'Tatras', 'tatras'];
        yield 'pattatras' => [ResultType::Pattatras, 15, 'Pattatras', 'pattatras'];
    }
}
