<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Baz;
use ArchPhp\Tests\Fixtures\Foo;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class CollectionContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'count' => [
            AccessorCaseBuilder::createClassCollection([Foo::class, Baz::class])
                ->withAccessor('count')
                ->expectType('number')
                ->expectValue(2),
        ];
        yield 'filter' => [
            AccessorCaseBuilder::createClassCollection([Foo::class, Baz::class])
                ->withAccessor('filter')
                ->withArgument('callback', static fn(): true => true)
                ->expectType('collection[class]')
                ->expectValue([Foo::class, Baz::class]),
        ];
    }

    #[DataProvider('provideAccessors')]
    #[Group('accessors')]
    public function testAccessors(AccessorCaseBuilder $accessorCaseBuilder): void
    {
        $this->assertAccessor($accessorCaseBuilder);
    }
}
