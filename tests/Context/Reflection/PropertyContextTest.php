<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\FooBar;
use PHPUnit\Framework\Attributes\TestDox;

final class PropertyContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of property context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->property('quux')
            ->access('name')->shouldBeString('quux')
            ->access('class')->shouldBeClass(Foo::class)
            ->access('type')->shouldBeType('string')
            ->access('attributes')->shouldBeCollectionOf('attribute', [FooBar::class])
            ->access('attribute')->withArgument('attribute', FooBar::class)->shouldBeAttribute(FooBar::class)
            ->assert('hasDefaultValue')->toBeTrue()
            ->assert('hasType')->toBeTrue()
            ->assert('isDefault')->toBeTrue()
            ->assert('isPrivate')->toBeFalse()
            ->assert('isPromoted')->toBeFalse()
            ->assert('isProtected')->toBeFalse()
            ->assert('isPublic')->toBeTrue()
            ->assert('isReadOnly')->toBeFalse()
            ->assert('isStatic')->toBeFalse()
        ;

        $this->assertContext($contextCase);
    }
}
