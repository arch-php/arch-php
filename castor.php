<?php

declare(strict_types=1);

use function Castor\import;
use function Castor\io;
use function composer\composer_install;

import(__DIR__ . '/.castor');

function install(): void
{
    io()->section('Installing Composer dependencies');
    composer_install();
}
