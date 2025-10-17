<?php

declare(strict_types=1);

namespace Tests\Unit\Assertion;

use Bonemeijer\PhpUnitExtensions\Assertion\JsonAssertionTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class JsonAssertionTraitTest extends TestCase
{
    use JsonAssertionTrait;

    /**
     * @return array<string, array<mixed>>
     */
    public static function dataProvider(): array
    {
        return [
            'with mixed data' => [
                'data' => [
                    'string'   => 'henlo, this is dog',
                    'int'      => 123,
                    'float'    => 123.456,
                    'null'     => null,
                    'true'     => true,
                    'false'    => false,
                    'datetime' => new \DateTime('2020-01-01 12:37:51', new \DateTimeZone('UTC')),
                    'array'    => [
                        'string' => 'henlo, this is dog',
                    ],
                    'object'   => (object) [
                        'string' => 'henlo, this is dog',
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array<mixed> $data
     */
    #[DataProvider('dataProvider')]
    public function testDataProvider(array $data): void
    {
        $assertion = $this->getJsonAssertion($data);
        $assertion->assertSame();
    }

    public function testMethod(): void
    {
        $assertion = $this->getJsonAssertion(
            [
                'string' => 'henlo, this is dog',
            ],
        );
        $assertion->assertSame();
    }
}
