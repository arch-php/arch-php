<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Baz;
use ArchPhp\Tests\Fixtures\Grault;
use ArchPhp\Tests\Fixtures\Quux;
use PHPUnit\Framework\Attributes\TestDox;

final class EnumContextTest extends ContextTestCase
{
    #[TestDox('Test initializer of class context')]
    public function testInitializer(): void
    {
        $context = $this->createContext(Grault::class);

        self::assertSame('enum', $context->getDefinition()->getId());

        $context = $this->createContext(new \ReflectionClass(Grault::class));

        self::assertSame('enum', $context->getDefinition()->getId());
    }

    #[TestDox('Test accessors and assertions of enum context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::enum(Grault::class)
            ->access('name')->shouldBeString(Grault::class)
            ->access('shortName')->shouldBeString('Grault')
            ->access('namespace')->shouldBeString('ArchPhp\Tests\Fixtures')
            ->access('type')->shouldBeType('string')
            ->access('interfaces')->shouldBeEmpty()
            ->access('traits')->shouldBeEmpty()
            ->access('attributes')->shouldBeCollectionOf('attribute', [Quux::class])
            ->access('attribute')->withArgument('attribute', Quux::class)->shouldBeAttribute(Quux::class)
            ->access('constants')->shouldBeCollectionOf('class_constant', ['FRED'])
            ->access('constant')->withArgument('constant', 'FRED')->shouldBeClassConstant('FRED')
            ->access('cases')->shouldBeCollectionOf('enum_case', ['Foo', 'Bar'])
            ->access('case')->withArgument('case', 'Foo')->shouldBeEnumCase('Foo')
            ->access('methods')->shouldBeCollectionOf('method', ['waldo', 'cases', 'from', 'tryFrom'])
            ->access('method')->withArgument('method', 'waldo')->shouldBeMethod('waldo')
            ->assert('isBacked')->toBeTrue()
            ->assert('hasCase')->withArgument('case', 'Foo')->toBeTrue()
            ->assert('isCloneable')->toBeFalse()
            ->assert('isInternal')->toBeFalse()
            ->assert('isUserDefined')->toBeTrue()
            ->assert('isInNamespace')->toBeTrue()
            ->assert('hasAttribute')->withArgument('attribute', Quux::class)->toBeTrue()
            ->assert('hasConstant')->withArgument('constant', 'FRED')->toBeTrue()
            ->assert('hasMethod')->withArgument('method', 'waldo')->toBeTrue()
            ->assert('implementsInterface')->withArgument('interface', Baz::class)->toBeFalse()
        ;

        $this->assertContext($contextCase);
    }
}
