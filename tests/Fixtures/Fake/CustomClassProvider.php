<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Fixtures\Fake;

use ArchPhp\Provider\Provider;

final readonly class CustomClassProvider implements Provider
{
    public function getName(): string
    {
        return 'classes';
    }

    public function provide(): iterable
    {
        yield from [];
    }
}
