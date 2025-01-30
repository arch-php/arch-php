<?php

declare(strict_types=1);

namespace qa;

use Castor\Attribute\AsTask;

use function Castor\io;
use function composer\composer_check;
use function ecs\ecs_check;
use function ecs\ecs_format;
use function phpstan\phpstan_check;
use function phpunit\phpunit_test;
use function rector\rector_check;
use function rector\rector_format;

#[AsTask(description: 'Runs analysis tools', aliases: ['check'])]
function check(): void
{
    composer_check();
    io()->newLine(2);
    rector_check();
    io()->newLine(2);
    ecs_check();
    io()->newLine(2);
    phpstan_check();
}

#[AsTask(description: 'Runs all formatters', aliases: ['format'])]
function format(): void
{
    rector_format();
    io()->newLine(2);
    ecs_format();
}

#[AsTask(description: 'Runs all tests', aliases: ['test'])]
function test(): void
{
    phpunit_test();
}

#[AsTask(description: 'Runs QA tools', aliases: ['qa'])]
function qa(): void
{
    format();
    io()->newLine(2);
    check();
    io()->newLine(2);
    test();
}
