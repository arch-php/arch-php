<?php

declare(strict_types=1);

namespace ArchPhp\Test;

use ArchPhp\Rule\Expression;

abstract class RuleTestCase extends ArchTestCase
{
    /**
     * @param array<string|int, mixed> $expectedArguments
     * @return Expression[]
     */
    public static function assertExpression(
        string $expectedName,
        int $expectedChildren,
        array $expectedArguments,
        Expression $expression,
    ): array {
        self::assertSame($expectedName, $expression->getName());
        self::assertCount($expectedChildren, $expression->getChildren());
        self::assertSame($expectedArguments, $expression->getArguments());

        return $expression->getChildren();
    }
}
