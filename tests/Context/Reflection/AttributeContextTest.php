<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\Quux;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class AttributeContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'class' => [
            AccessorCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAccessor('class')
                ->expectType('class')
                ->expectValue(Quux::class),
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
        yield 'isRepeated' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('isRepeated'),
        ];

        yield 'isRepeatable' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('isRepeatable'),
        ];

        yield 'targetClass' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('targetClass'),
        ];

        yield 'targetFunction' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('targetFunction')
                ->expectToBeFalse(),
        ];

        yield 'targetProperty' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('targetProperty')
                ->expectToBeFalse(),
        ];

        yield 'targetConstant' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('targetConstant')
                ->expectToBeFalse(),
        ];

        yield 'targetParameter' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('targetParameter')
                ->expectToBeFalse(),
        ];

        yield 'targetAll' => [
            AssertionCaseBuilder::createClassAttribute(Foo::class, Quux::class)
                ->withAssertion('targetAll')
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
