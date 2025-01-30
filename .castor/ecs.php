<?php

declare(strict_types=1);

namespace ecs;

use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;

#[AsTask(name: 'check', description: 'Checks ECS rules')]
function ecs_check(): void
{
    io()->title('Checking ECS rules');

    run(['vendor/bin/ecs']);
}

#[AsTask(name: 'format', description: 'Applies ECS rules')]
function ecs_format(): void
{
    io()->title('Applying ECS rules');

    run(['vendor/bin/ecs', '--fix']);
}
