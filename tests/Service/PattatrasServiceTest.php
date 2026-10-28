<?php

declare(strict_types=1);

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

    /**
     * Vérifie la transformation pour chaque couple nombre/résultat fourni par transformProvider.
     */
    #[DataProvider('transformProvider')]
    public function testTransform(int $number, string $expected): void
    {
        self::assertSame($expected, $this->service->transform($number));
    }

    /**
     * Fournit les cas métier et des valeurs proches de la borne supérieure.
     *
     * @return iterable<string, array{int, string}>
     */
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

    /**
     * Vérifie la taille de la plage par défaut, ses extrémités et un résultat de remplacement.
     */
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

    /**
     * Vérifie les quatre catégories utilisées par la page pour distinguer les résultats.
     */
    public function testGenerateIncludesSemanticTypes(): void
    {
        $results = $this->service->generate(2, 15);

        self::assertSame('number', $results[0]['type']);
        self::assertSame('patte', $results[1]['type']);
        self::assertSame('tatras', $results[3]['type']);
        self::assertSame('pattatras', $results[13]['type']);
    }

    /**
     * Vérifie qu'une plage inversée est refusée avec l'exception et le message attendus.
     */
    public function testGenerateRejectsReversedRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIs('La borne de début doit être inférieure ou égale à la borne de fin.');

        $this->service->generate(2, 1);
    }
}
