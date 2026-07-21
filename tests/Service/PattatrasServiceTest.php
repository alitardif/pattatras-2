<?php

namespace App\Tests\Service;

use App\Service\PattatrasService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PattatrasServiceTest extends TestCase
{
    private PattatrasService $service;

    protected function setUp(): void
    {
        $this->service = new PattatrasService();
    }

    #[DataProvider('transformProvider')]
    public function testTransform(int $number, string $expected): void
    {
        self::assertSame($expected, $this->service->transform($number));
    }

    public static function transformProvider(): iterable
    {
        yield 'nombre simple' => [1, '1'];
        yield 'multiple de 3' => [3, 'Patte'];
        yield 'multiple de 5' => [5, 'Tatras'];
        yield 'multiple de 3 et 5' => [15, 'Pattatras'];
        yield '6450 multiple de 3 et 5' => [6450, 'Pattatras'];
        yield 'dernière borne' => [6457, '6457'];
        yield '6456 multiple de 3' => [6456, 'Patte'];
        yield '6455 multiple de 5' => [6455, 'Tatras'];
    }

    public function testGenerateDefaultRange(): void
    {
        $results = $this->service->generate();

        self::assertCount(6457, $results);
        self::assertSame(1, $results[0]['number']);
        self::assertSame('1', $results[0]['value']);
        self::assertSame(6457, $results[6456]['number']);
        self::assertSame('6457', $results[6456]['value']);
        self::assertSame('Pattatras', $results[14]['value']);
    }
}
