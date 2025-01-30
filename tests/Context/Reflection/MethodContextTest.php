<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\FooBar;
use PHPUnit\Framework\Attributes\TestDox;

final class MethodContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of method context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->method('waldo')
            ->access('name')->shouldBeString('waldo')
            ->access('returnType')->shouldBeType('void')
            ->access('class')->shouldBeClass(Foo::class)
            ->access('attributes')->shouldBeCollectionOf('attribute', [FooBar::class])
            ->access('attribute')->withArgument('attribute', FooBar::class)->shouldBeAttribute(FooBar::class)
            ->access('parameters')->shouldBeCollectionOf('parameter', ['bar'])
            ->access('parameter')->withArgument('parameter', 'bar')->shouldBeParameter('bar')
            ->assert('hasParameter')->withArgument('parameter', 'bar')->toBeTrue()
            ->assert('hasReturnType')->toBeTrue()
            ->assert('isAbstract')->toBeFalse()
            ->assert('isPrivate')->toBeFalse()
            ->assert('isConstructor')->toBeFalse()
            ->assert('isDestructor')->toBeFalse()
            ->assert('isProtected')->toBeFalse()
            ->assert('isPublic')->toBeTrue()
            ->assert('isStatic')->toBeFalse()
        ;

        $this->assertContext($contextCase);
    }
}
