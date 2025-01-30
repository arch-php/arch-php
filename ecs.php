<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withCache(__DIR__ . '/var/cache/ecs')
    ->withPaths([__DIR__ . '/.castor', __DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withPhpCsFixerSets(perCS20: true);
