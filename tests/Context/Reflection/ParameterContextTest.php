<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\FooBar;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class ParameterContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue('bar'),
        ];
        yield 'position' => [
            AccessorCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAccessor('position')
                ->expectType('number')
                ->expectValue(0),
        ];
        yield 'method' => [
            AccessorCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAccessor('method')
                ->expectType('method')
                ->expectValue('waldo'),
        ];
        yield 'type' => [
            AccessorCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAccessor('type')
                ->expectType('type')
                ->expectValue('string'),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([FooBar::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAccessor('attribute')
                ->withArgument('attribute', FooBar::class)
                ->expectType('attribute')
                ->expectValue(FooBar::class),
        ];
    }

    #[DataProvider('provideAccessors')]
    #[Group('accessors')]
    public function testAccessors(AccessorCaseBuilder $accessorCaseBuilder): void
    {
        $this->assertAccessor($accessorCaseBuilder);
    }

    /**
     * @return iterable<string, array{AssertionCaseBuilder}>
     */
    public static function provideAssertions(): iterable
    {
        yield 'allowsNull' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('allowsNull')
                ->expectToBeFalse(),
        ];
        yield 'canBePassedByValue' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('canBePassedByValue'),
        ];
        yield 'hasType' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('hasType'),
        ];
        yield 'isDefaultValueAvailable' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('isDefaultValueAvailable')
                ->expectToBeFalse(),
        ];
        yield 'isOptional' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('isOptional')
                ->expectToBeFalse(),
        ];
        yield 'isPassedByReference' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('isPassedByReference')
                ->expectToBeFalse(),
        ];
        yield 'isPromoted' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('isPromoted')
                ->expectToBeFalse(),
        ];
        yield 'isVariadic' => [
            AssertionCaseBuilder::createParameter(Foo::class, 'waldo', 'bar')
                ->withAssertion('isVariadic')
                ->expectToBeFalse(),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
