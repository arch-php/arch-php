<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Scalar;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class StringContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'length' => [
            AccessorCaseBuilder::createScalar(Foo::class)
                ->withAccessor('length')
                ->expectType('number')
                ->expectValue(26),
        ];
        yield 'before' => [
            AccessorCaseBuilder::createScalar(Foo::class)
                ->withAccessor('before')
                ->withArgument('needle', '\\')
                ->expectType('string')
                ->expectValue('ArchPhp'),
        ];
        yield 'beforeLast' => [
            AccessorCaseBuilder::createScalar(Foo::class)
                ->withAccessor('beforeLast')
                ->withArgument('needle', '\\')
                ->expectType('string')
                ->expectValue('ArchPhp\\Tests\\Fixtures'),
        ];
        yield 'after' => [
            AccessorCaseBuilder::createScalar(Foo::class)
                ->withAccessor('after')
                ->withArgument('needle', '\\')
                ->expectType('string')
                ->expectValue('Tests\\Fixtures\\Foo'),
        ];
        yield 'afterLast' => [
            AccessorCaseBuilder::createScalar(Foo::class)
                ->withAccessor('afterLast')
                ->withArgument('needle', '\\')
                ->expectType('string')
                ->expectValue('Foo'),
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
        yield 'isIdenticalTo' => [
            AssertionCaseBuilder::createScalar(Foo::class)
                ->withAssertion('isIdenticalTo')
                ->withArgument('expected', Foo::class),
        ];
        yield 'isEmpty' => [
            AssertionCaseBuilder::createScalar(Foo::class)
                ->withAssertion('isEmpty')
                ->expectToBeFalse(),
        ];
        yield 'contains' => [
            AssertionCaseBuilder::createScalar(Foo::class)
                ->withAssertion('contains')
                ->withArgument('needle', 'Foo'),
        ];
        yield 'startsWith' => [
            AssertionCaseBuilder::createScalar(Foo::class)
                ->withAssertion('startsWith')
                ->withArgument('prefix', 'ArchPhp'),
        ];
        yield 'endsWith' => [
            AssertionCaseBuilder::createScalar(Foo::class)
                ->withAssertion('endsWith')
                ->withArgument('suffix', 'Foo'),
        ];
        yield 'matchesWith' => [
            AssertionCaseBuilder::createScalar(Foo::class)
                ->withAssertion('matchesWith')
                ->withArgument('pattern', '/^ArchPhp/'),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
