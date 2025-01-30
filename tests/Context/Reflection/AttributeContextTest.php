<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\Quux;
use PHPUnit\Framework\Attributes\TestDox;

final class AttributeContextTest extends ContextTestCase
{
    #[TestDox('Test accessors and assertions of attribute context')]
    public function testContext(): void
    {
        $contextCase = ContextBuilder::class(Foo::class)
            ->attribute(Quux::class)
            ->access('class')->shouldBeClass(Quux::class)
            ->assert('isRepeated')->toBeTrue()
            ->assert('isRepeatable')->toBeTrue()
            ->assert('targetClass')->toBeTrue()
            ->assert('targetFunction')->toBeFalse()
            ->assert('targetProperty')->toBeFalse()
            ->assert('targetConstant')->toBeFalse()
            ->assert('targetMethod')->toBeFalse()
            ->assert('targetParameter')->toBeFalse()
            ->assert('targetAll')->toBeFalse()
        ;

        $this->assertContext($contextCase);
    }
}
