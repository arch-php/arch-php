<?php

declare(strict_types=1);

namespace composer;

use Symfony\Component\Process\Process;
use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;

#[AsTask(name: 'install', description: 'Installs Composer dependencies', aliases: ['install'])]
function composer_install(): Process
{
    return run(['composer', 'install']);
}

#[AsTask(name: 'install:ci', description: 'Installs Composer dependencies')]
function composer_install_ci(): Process
{
    return run(['composer', 'install', '--prefer-dist']);
}

#[AsTask(name: 'update', description: 'Updates Composer dependencies', aliases: ['update'])]
function composer_update(): Process
{
    return run(['composer', 'update']);
}

#[AsTask(name: 'check', description: 'Runs Composer checks')]
function composer_check(): void
{
    io()->title('Running composer checks');

    io()->section('Validating composer file');
    run(['composer', 'validate', '--check-lock', '--strict']);
    io()->newLine(2);

    io()->section('Checking outdated dependencies (minor)');
    run(['composer', 'outdated', '--direct', '--strict', '--minor-only', '--locked']);
    io()->newLine(2);

    io()->section('Checking outdated dependencies (patch)');
    run(['composer', 'outdated', '--direct', '--strict', '--patch-only', '--locked']);
    io()->newLine(2);

    io()->section('Checking requirements');
    run(['composer', 'check-platform-reqs', '--lock']);
    io()->newLine(2);

    io()->section('Running audit');
    run(['composer', 'audit', '--locked']);
}
