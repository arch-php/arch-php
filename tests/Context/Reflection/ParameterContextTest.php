<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\FooBar;
use PHPUnit\Framework\Attributes\TestDox;

final class ParameterContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of parameter context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->method('waldo')
            ->parameter('bar')
            ->access('name')->shouldBeString('bar')
            ->access('position')->shouldBeNumber(0)
            ->access('method')->shouldBeMethod('waldo')
            ->access('type')->shouldBeType('string')
            ->access('attributes')->shouldBeCollectionOf('attribute', [FooBar::class])
            ->access('attribute')->withArgument('attribute', FooBar::class)->shouldBeAttribute(FooBar::class)
            ->assert('allowsNull')->toBeFalse()
            ->assert('canBePassedByValue')->toBeTrue()
            ->assert('hasType')->toBeTrue()
            ->assert('isDefaultValueAvailable')->toBeFalse()
            ->assert('isOptional')->toBeFalse()
            ->assert('isPassedByReference')->toBeFalse()
            ->assert('isPromoted')->toBeFalse()
            ->assert('isVariadic')->toBeFalse()
        ;

        $this->assertContext($contextCase);
    }
}
