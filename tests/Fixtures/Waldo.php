<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Fixtures;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
final class Waldo
{
    public function __construct(public string $foo) {}
}
