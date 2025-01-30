<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class TypeContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue('string'),
        ];
        yield 'class' => [
            AccessorCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAccessor('class')
                ->expectType('null')
                ->expectValue(null),
        ];
        yield 'types' => [
            AccessorCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAccessor('types')
                ->expectType('empty')
                ->expectValue([]),
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
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('allowsNull')
                ->expectToBeFalse(),
        ];
        yield 'isNamed' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isNamed'),
        ];
        yield 'isBuiltIn' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isBuiltIn'),
        ];
        yield 'isClass' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isClass')
                ->expectToBeFalse(),
        ];
        yield 'isInterface' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isInterface')
                ->expectToBeFalse(),
        ];
        yield 'isEnum' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isEnum')
                ->expectToBeFalse(),
        ];
        yield 'isTrait' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isTrait')
                ->expectToBeFalse(),
        ];
        yield 'isUnion' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isUnion')
                ->expectToBeFalse(),
        ];
        yield 'isIntersection' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isIntersection')
                ->expectToBeFalse(),
        ];
        yield 'isA' => [
            AssertionCaseBuilder::createPropertyType(Foo::class, 'quux')
                ->withAssertion('isA')
                ->withArgument('type', 'string'),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
