<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\FooBar;
use PHPUnit\Framework\Attributes\TestDox;

final class ClassConstantContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of class_constant context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->constant('FRED')
            ->access('name')->shouldBeString('FRED')
            ->access('class')->shouldBeClass(Foo::class)
            ->access('type')->shouldBeType('string')
            ->access('attributes')->shouldBeCollectionOf('attribute', [FooBar::class])
            ->access('attribute')->withArgument('attribute', FooBar::class)->shouldBeAttribute(FooBar::class)
            ->assert('hasType')->toBeTrue()
            ->assert('isPrivate')->toBeFalse()
            ->assert('isProtected')->toBeFalse()
            ->assert('isPublic')->toBeTrue()
        ;

        $this->assertContext($contextCase);
    }
}
