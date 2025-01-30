<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Bar;
use ArchPhp\Tests\Fixtures\Baz;
use ArchPhp\Tests\Fixtures\Corge;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\Quux;
use ArchPhp\Tests\Fixtures\Qux;
use ArchPhp\Tests\Fixtures\Quxxes;
use PHPUnit\Framework\Attributes\TestDox;

final class ClassContextTest extends ContextTestCase
{
    #[TestDox('Test initializer of class context')]
    public function testInitializer(): void
    {
        $context = $this->createContext(Foo::class);

        self::assertSame('class', $context->getDefinition()->getId());
    }

    #[TestDox('Test accessors and assertions of class context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->access('name')->shouldBeString(Foo::class)
            ->access('shortName')->shouldBeString('Foo')
            ->access('namespace')->shouldBeString('ArchPhp\Tests\Fixtures')
            ->access('parent')->shouldBeClass(Bar::class)
            ->access('interfaces')->shouldBeCollectionOf('class', [Baz::class, Qux::class, Corge::class])
            ->access('traits')->shouldBeCollectionOf('class', [Quxxes::class])
            ->access('attributes')->shouldBeCollectionOf('attribute', [Quux::class, Quux::class])
            ->access('attribute')->withArgument('attribute', Quux::class)->shouldBeAttribute(Quux::class)
            ->access('constants')->shouldBeCollectionOf('class_constant', ['FRED', 'PLUGH'])
            ->access('constant')->withArgument('constant', 'FRED')->shouldBeClassConstant('FRED')
            ->access('properties')->shouldBeCollectionOf('property', ['quux', 'garply', 'waldo', 'fooBar', 'grault'])
            ->access('property')->withArgument('property', 'quux')->shouldBeProperty('quux')
            ->access('methods')->shouldBeCollectionOf('method', ['__construct', 'waldo', 'xyzzy', 'quux', 'bar', 'baz', 'qux', 'thud', 'foo'])
            ->access('method')->withArgument('method', 'waldo')->shouldBeMethod('waldo')
            ->assert('hasParent')->toBeTrue()
            ->assert('hasConstructor')->toBeTrue()
            ->assert('isAbstract')->toBeFalse()
            ->assert('isCloneable')->toBeTrue()
            ->assert('isFinal')->toBeTrue()
            ->assert('isInstantiable')->toBeTrue()
            ->assert('isInterface')->toBeFalse()
            ->assert('isInternal')->toBeFalse()
            ->assert('isIterable')->toBeFalse()
            ->assert('isReadOnly')->toBeFalse()
            ->assert('isTrait')->toBeFalse()
            ->assert('isUserDefined')->toBeTrue()
            ->assert('isInNamespace')->toBeTrue()
            ->assert('hasProperty')->withArgument('property', 'quux')->toBeTrue()
            ->assert('hasAttribute')->withArgument('attribute', Quux::class)->toBeTrue()
            ->assert('hasConstant')->withArgument('constant', 'FRED')->toBeTrue()
            ->assert('hasMethod')->withArgument('method', 'waldo')->toBeTrue()
            ->assert('implementsInterface')->withArgument('interface', Baz::class)->toBeTrue()
            ->assert('usesTrait')->withArgument('trait', Quxxes::class)->toBeTrue()
            ->assert('isSubclassOf')->withArgument('class', Bar::class)->toBeTrue()
        ;

        $this->assertContext($contextCase);
    }

    #[TestDox('Test memoized with args')]
    public function testMemoizedWithArgs(): void
    {
        $context = $this->createContext(Foo::class);

        $accessors = new \ReflectionProperty($context, 'accessors');
        $calls = new \ReflectionProperty($context, 'accessorsCalls');

        $assertAccessor = static function (string $key, string $accessor, string $arg, string $value, int $expectedCalls) use ($context, $accessors, $calls): void {
            $contextWaldo = $context->access($accessor, [$arg => $value]);

            self::assertNotNull($contextWaldo);

            $methodWaldo = $contextWaldo->getValue();

            self::assertInstanceOf(\ReflectionMethod::class, $methodWaldo);

            self::assertSame($value, $methodWaldo->getName());

            $accessors = $accessors->getValue($context);

            self::assertIsArray($accessors);
            self::assertArrayHasKey($key, $accessors);

            $calls = $calls->getValue($context);

            self::assertIsArray($calls);
            self::assertArrayHasKey($key, $calls);
            self::assertSame($expectedCalls, $calls[$key]);
        };

        $assertAccessor('method?method=waldo', 'method', 'method', 'waldo', 1);
        $assertAccessor('method?method=xyzzy', 'method', 'method', 'xyzzy', 1);
        $assertAccessor('method?method=waldo', 'method', 'method', 'waldo', 2);
    }
}
