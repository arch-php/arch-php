<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Scalar;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use PHPUnit\Framework\Attributes\TestDox;

final class NumberContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of number context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::scalar(10)
            ->assert('equalsTo')->withArgument('expected', 10)->toBeTrue()
            ->assert('greaterThan')->withArgument('limit', 9)->toBeTrue()
            ->assert('greaterThanOrEqual')->withArgument('limit', 10)->toBeTrue()
            ->assert('lessThan')->withArgument('limit', 11)->toBeTrue()
            ->assert('lessThanOrEqual')->withArgument('limit', 10)->toBeTrue()
            ->assert('isZero')->toBeFalse()
            ->assert('isNegative')->toBeFalse()
            ->assert('isNegativeOrZero')->toBeFalse()
            ->assert('isPositive')->toBeTrue()
            ->assert('isPositiveOrZero')->toBeTrue()
        ;

        $this->assertContext($contextCase);
    }
}
