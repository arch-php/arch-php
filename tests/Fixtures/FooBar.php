<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Fixtures;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS_CONSTANT | \Attribute::TARGET_METHOD | \Attribute::TARGET_PARAMETER)]
final class FooBar
{
    public function __construct(public string $foo) {}
}
