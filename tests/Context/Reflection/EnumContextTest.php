<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Grault;
use ArchPhp\Tests\Fixtures\Quux;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class EnumContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue(Grault::class),
        ];
        yield 'shortName' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('shortName')
                ->expectType('string')
                ->expectValue('Grault'),
        ];
        yield 'namespace' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('namespace')
                ->expectType('string')
                ->expectValue('ArchPhp\Tests\Fixtures'),
        ];
        yield 'type' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('type')
                ->expectType('type')
                ->expectValue('string'),
        ];
        yield 'cases' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('cases')
                ->expectType('collection[enum_case]')
                ->expectValue(['Foo', 'Bar']),
        ];
        yield 'case' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('case')
                ->withArgument('case', 'Foo')
                ->expectType('enum_case')
                ->expectValue('Foo'),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([Quux::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('attribute')
                ->withArgument('attribute', Quux::class)
                ->expectType('attribute')
                ->expectValue(Quux::class),
        ];
        yield 'constants' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('constants')
                ->expectType('collection[class_constant]')
                ->expectValue(['FRED']),
        ];
        yield 'constant' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('constant')
                ->withArgument('constant', 'FRED')
                ->expectType('class_constant')
                ->expectValue('FRED'),
        ];
        yield 'methods' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('methods')
                ->expectType('collection[method]')
                ->expectValue(['waldo', 'cases', 'from', 'tryFrom']),
        ];
        yield 'method' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('method')
                ->withArgument('method', 'waldo')
                ->expectType('method')
                ->expectValue('waldo'),
        ];
        yield 'interfaces' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('interfaces')
                ->expectType('empty')
                ->expectValue([]),
        ];
        yield 'traits' => [
            AccessorCaseBuilder::createEnum(Grault::class)
                ->withAccessor('traits')
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
        yield 'isBacked' => [
            AssertionCaseBuilder::createEnum(Grault::class)
                ->withAssertion('isBacked'),
        ];
        yield 'hasCase' => [
            AssertionCaseBuilder::createEnum(Grault::class)
                ->withAssertion('hasCase')
                ->withArgument('case', 'Foo'),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
