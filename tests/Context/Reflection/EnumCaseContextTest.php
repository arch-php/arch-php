<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\FooBar;
use ArchPhp\Tests\Fixtures\Grault;
use PHPUnit\Framework\Attributes\TestDox;

final class EnumCaseContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of enum_case context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::enum(Grault::class)
            ->case('Foo')
            ->access('name')->shouldBeString('Foo')
            ->access('enum')->shouldBeEnum(Grault::class)
            ->access('value')->shouldBeString('foo')
            ->access('attributes')->shouldBeCollectionOf('attribute', [FooBar::class])
            ->access('attribute')->withArgument('attribute', FooBar::class)->shouldBeAttribute(FooBar::class)
        ;

        $this->assertContext($contextCase);
    }
}
