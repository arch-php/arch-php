<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Expression;

use ArchPhp\Expression\Expression;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class ExpressionTest extends TestCase
{
    #[TestDox('Test expression')]
    public function testExpression(): void
    {
        $expression = (new Expression('classes', [], null))
            ->that()->isInstantiable()->end()
            ->should()->beFinal()->end();

        self::assertTrue($expression->isRoot());
        self::assertEquals(
            [
                'name' => 'classes',
                'arguments' => [],
                'children' => [
                    [
                        'name' => 'that',
                        'arguments' => [],
                        'children' => [
                            [
                                'name' => 'isInstantiable',
                                'arguments' => [],
                                'children' => [],
                            ],
                        ],
                    ],
                    [
                        'name' => 'should',
                        'arguments' => [],
                        'children' => [
                            [
                                'name' => 'beFinal',
                                'arguments' => [],
                                'children' => [],
                            ],
                        ],
                    ],
                ],
            ],
            $expression->toArray(),
        );
    }
}
