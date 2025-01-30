<?php

declare(strict_types=1);

namespace phpunit;

use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;

#[AsTask(name: 'test', description: 'Runs PHPUnit tests')]
function phpunit_test(): void
{
    io()->title('Running PHPUnit tests');

    run(['vendor/bin/phpunit', '--coverage-text']);
}
