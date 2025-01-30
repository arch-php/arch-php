<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;

return RectorConfig::configure()
    ->withCache(__DIR__ . '/var/cache/rector')
    ->withPaths([__DIR__ . '/.castor', __DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withSkipPath(__DIR__ . '/tests/Fixtures')
    ->withRootFiles()
    ->withComposerBased(phpunit: true)
    ->withPHPStanConfigs([__DIR__ . '/phpstan.neon'])
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
        SetList::NAMING,
        SetList::PHP_84,
        SetList::STRICT_BOOLEANS,
        SetList::TYPE_DECLARATION,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ])
    ->withRules([
        AddArrowFunctionReturnTypeRector::class,
        StaticClosureRector::class,
        StaticArrowFunctionRector::class,
    ])
    ->withSkip([
        PreferPHPUnitThisCallRector::class,
        RenameParamToMatchTypeRector::class,
        RenamePropertyToMatchTypeRector::class,
    ])
    ->withAttributesSets(phpunit: true);
