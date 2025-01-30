<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\FooBar;
use ArchPhp\Tests\Fixtures\FooGrault;
use ArchPhp\Tests\Fixtures\Grault;
use ArchPhp\Tests\Fixtures\Xyzzy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class EnumCaseContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createEnumCase(Grault::class, 'Foo')
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue('Foo'),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createEnumCase(Grault::class, 'Foo')
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([FooBar::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createEnumCase(Grault::class, 'Foo')
                ->withAccessor('attribute')
                ->withArgument('attribute', FooBar::class)
                ->expectType('attribute')
                ->expectValue(FooBar::class),
        ];
        yield 'enum' => [
            AccessorCaseBuilder::createEnumCase(Grault::class, 'Foo')
                ->withAccessor('enum')
                ->expectType('enum')
                ->expectValue(Grault::class),
        ];
        yield 'string value' => [
            AccessorCaseBuilder::createEnumCase(Grault::class, 'Foo')
                ->withAccessor('value')
                ->expectType('string')
                ->expectValue('foo'),
        ];
        yield 'number value' => [
            AccessorCaseBuilder::createEnumCase(FooGrault::class, 'Foo')
                ->withAccessor('value')
                ->expectType('number')
                ->expectValue(1),
        ];
        yield 'null value' => [
            AccessorCaseBuilder::createEnumCase(Xyzzy::class, 'Foo')
                ->withAccessor('value')
                ->expectType('null')
                ->expectValue(null),
        ];
    }

    #[DataProvider('provideAccessors')]
    #[Group('accessors')]
    public function testAccessors(AccessorCaseBuilder $accessorCaseBuilder): void
    {
        $this->assertAccessor($accessorCaseBuilder);
    }
}
