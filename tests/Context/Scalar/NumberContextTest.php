<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Scalar;

use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class NumberContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AssertionCaseBuilder}>
     */
    public static function provideAssertions(): iterable
    {
        yield 'equalsTo' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('equalsTo')
                ->withArgument('expected', 10),
        ];
        yield 'greaterThan' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('greaterThan')
                ->withArgument('limit', 9),
        ];
        yield 'greaterThanOrEqual' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('greaterThanOrEqual')
                ->withArgument('limit', 10),
        ];
        yield 'lessThan' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('lessThan')
                ->withArgument('limit', 11),
        ];
        yield 'lessThanOrEqual' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('lessThanOrEqual')
                ->withArgument('limit', 10),
        ];
        yield 'isZero' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('isZero')
                ->expectToBeFalse(),
        ];
        yield 'isNegative' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('isNegative')
                ->expectToBeFalse(),
        ];
        yield 'isNegativeOrZero' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('isNegativeOrZero')
                ->expectToBeFalse(),
        ];
        yield 'isPositive' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('isPositive'),
        ];
        yield 'isPositiveOrZero' => [
            AssertionCaseBuilder::createScalar(10)
                ->withAssertion('isPositiveOrZero'),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
