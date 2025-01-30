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

final class ClassConstantContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue('FRED'),
        ];
        yield 'class' => [
            AccessorCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAccessor('class')
                ->expectType('class')
                ->expectValue(Foo::class),
        ];
        yield 'type' => [
            AccessorCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAccessor('type')
                ->expectType('type')
                ->expectValue('string'),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([FooBar::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createClassConstant(Foo::class, 'FRED')
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
        yield 'hasType' => [
            AssertionCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAssertion('hasType'),
        ];
        yield 'isPrivate' => [
            AssertionCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAssertion('isPrivate')
                ->expectToBeFalse(),
        ];
        yield 'isProtected' => [
            AssertionCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAssertion('isProtected')
                ->expectToBeFalse(),
        ];
        yield 'isPublic' => [
            AssertionCaseBuilder::createClassConstant(Foo::class, 'FRED')
                ->withAssertion('isPublic'),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
