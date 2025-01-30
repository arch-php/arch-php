<?php

declare(strict_types=1);

namespace rector;

use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;

#[AsTask(name: 'format', description: 'Applies Rector rules')]
function rector_format(): void
{
    io()->title('Applying Rector rules');

    run(['vendor/bin/rector', 'process']);
}

#[AsTask(name: 'check', description: 'Checks Rector rules')]
function rector_check(): void
{
    io()->title('Checking Rector rules');

    run(['vendor/bin/rector', 'process', '--dry-run']);
}
