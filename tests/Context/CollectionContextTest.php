<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Baz;
use ArchPhp\Tests\Fixtures\Foo;
use PHPUnit\Framework\Attributes\TestDox;

final class CollectionContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of collection context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::classes(Foo::class, Baz::class)
            ->access('count')->shouldBeNumber(2)
            ->access('filter')->withArgument('callback', static fn(): true => true)->shouldBeCollectionOf('class', [Foo::class, Baz::class])
        ;

        $this->assertContext($contextCase);
    }

    #[TestDox('Test non memoized filter')]
    public function testNonMemoizedFilter(): void
    {
        $context = $this->createContext([
            $this->createContext(Foo::class),
            $this->createContext(Baz::class),
        ]);

        self::assertSame('collection[class]', $context->guessType());

        $reflectionProperty = new \ReflectionProperty($context, 'accessors');

        $filtered = $context->access('filter', ['callback' => static fn(): true => true]);

        self::assertNotNull($filtered);

        $count = $filtered->access('count', []);

        self::assertNotNull($count);

        self::assertSame(2, $count->getFormattedValue());

        $accessors = $reflectionProperty->getValue($context);

        self::assertIsArray($accessors);
        self::assertArrayNotHasKey('filter?', $accessors);
    }
}
