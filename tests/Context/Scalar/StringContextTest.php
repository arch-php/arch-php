<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Scalar;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use PHPUnit\Framework\Attributes\TestDox;

final class StringContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of string context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::scalar(Foo::class)
            ->access('length')->shouldBeNumber(26)
            ->access('before')->withArgument('needle', '\\')->shouldBeString('ArchPhp')
            ->access('beforeLast')->withArgument('needle', '\\')->shouldBeString('ArchPhp\\Tests\\Fixtures')
            ->access('after')->withArgument('needle', '\\')->shouldBeString('Tests\\Fixtures\\Foo')
            ->access('afterLast')->withArgument('needle', '\\')->shouldBeString('Foo')
            ->assert('isIdenticalTo')->withArgument('expected', Foo::class)->toBeTrue()
            ->assert('contains')->withArgument('needle', 'Foo')->toBeTrue()
            ->assert('startsWith')->withArgument('prefix', 'ArchPhp')->toBeTrue()
            ->assert('endsWith')->withArgument('suffix', 'Foo')->toBeTrue()
            ->assert('matchesWith')->withArgument('pattern', '/^ArchPhp/')->toBeTrue()
            ->assert('isEmpty')->toBeFalse()
        ;

        $this->assertContext($contextCase);
    }
}
