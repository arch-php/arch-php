<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use PHPUnit\Framework\Attributes\TestDox;

final class TypeContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of type context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->property('quux')
            ->type()
            ->access('name')->shouldBeString('string')
            ->access('class')->shouldBeNull()
            ->access('types')->shouldBeEmpty()
            ->assert('allowsNull')->toBeFalse()
            ->assert('isNamed')->toBeTrue()
            ->assert('isBuiltIn')->toBeTrue()
            ->assert('isClass')->toBeFalse()
            ->assert('isInterface')->toBeFalse()
            ->assert('isEnum')->toBeFalse()
            ->assert('isTrait')->toBeFalse()
            ->assert('isUnion')->toBeFalse()
            ->assert('isIntersection')->toBeFalse()
            ->assert('isA')->withArgument('type', 'string')->toBeTrue()
        ;

        $this->assertContext($contextCase);
    }
}
