<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Rule;

use ArchPhp\Rule\Rule;
use ArchPhp\Test\RuleTestCase;

final class RuleTest extends RuleTestCase
{
    public function testSimpleRule(): void
    {
        $rule = Rule::classes()
            ->that()
                ->namespace()->startsWith('ArchPhp\\Context')->end()
            ->end()
            ->should()
                ->shortName()->endsWith('Context')->end()
            ->end()
        ;

        [$that, $should] = self::assertExpression('classes', 2, [], $rule->getExpression());

        [$namespace] = self::assertExpression('that', 1, [], $that);
        [$startsWith] = self::assertExpression('namespace', 1, [], $namespace);
        self::assertExpression('startsWith', 0, ['ArchPhp\\Context'], $startsWith);

        [$shortName] = self::assertExpression('should', 1, [], $should);
        [$endsWith] = self::assertExpression('shortName', 1, [], $shortName);
        self::assertExpression('endsWith', 0, ['Context'], $endsWith);

    }
}
