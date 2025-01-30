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

final class MethodContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue('waldo'),
        ];
        yield 'class' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAccessor('class')
                ->expectType('class')
                ->expectValue(Foo::class),
        ];
        yield 'returnType' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAccessor('returnType')
                ->expectType('type')
                ->expectValue('void'),
        ];
        yield 'parameters' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAccessor('parameters')
                ->expectType('collection[parameter]')
                ->expectValue(['bar']),
        ];
        yield 'parameter' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAccessor('parameter')
                ->withArgument('parameter', 'bar')
                ->expectType('parameter')
                ->expectValue('bar'),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([FooBar::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createMethod(Foo::class, 'waldo')
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
        yield 'hasParameter' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('hasParameter')
                ->withArgument('parameter', 'bar'),
        ];
        yield 'hasReturnType' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('hasReturnType'),
        ];
        yield 'isAbstract' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('isAbstract')
                ->expectToBeFalse(),
        ];
        yield 'isPrivate' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('isPrivate')
                ->expectToBeFalse(),
        ];
        yield 'isConstructor' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('isConstructor')
                ->expectToBeFalse(),
        ];
        yield 'isDestructor' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('isDestructor')
                ->expectToBeFalse(),
        ];
        yield 'isProtected' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('isProtected')
                ->expectToBeFalse(),
        ];
        yield 'isPublic' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
                ->withAssertion('isPublic'),
        ];
        yield 'isStatic' => [
            AssertionCaseBuilder::createMethod(Foo::class, 'waldo')
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
