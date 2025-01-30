<?php

declare(strict_types=1);

namespace phpstan;

use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;

#[AsTask(name: 'check', description: 'Runs PHPStan analyse')]
function phpstan_check(): void
{
    io()->title('Running PHPStan analyse');

    run(['vendor/bin/phpstan', 'analyse', '--configuration', 'phpstan.neon']);
}
