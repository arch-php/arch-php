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

final class PropertyContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue('quux'),
        ];
        yield 'class' => [
            AccessorCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAccessor('class')
                ->expectType('class')
                ->expectValue(Foo::class),
        ];
        yield 'type' => [
            AccessorCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAccessor('type')
                ->expectType('type')
                ->expectValue('string'),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([FooBar::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createProperty(Foo::class, 'quux')
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
        yield 'hasDefaultValue' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('hasDefaultValue'),
        ];
        yield 'hasType' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('hasType'),
        ];
        yield 'isDefault' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isDefault'),
        ];
        yield 'isPrivate' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isPrivate')
                ->expectToBeFalse(),
        ];
        yield 'isPromoted' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isPromoted')
                ->expectToBeFalse(),
        ];
        yield 'isProtected' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isProtected')
                ->expectToBeFalse(),
        ];
        yield 'isPublic' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isPublic'),
        ];
        yield 'isReadOnly' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isReadOnly')
                ->expectToBeFalse(),
        ];
        yield 'isStatic' => [
            AssertionCaseBuilder::createProperty(Foo::class, 'quux')
                ->withAssertion('isStatic')
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
