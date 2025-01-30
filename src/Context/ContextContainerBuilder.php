<?php

declare(strict_types=1);

namespace ArchPhp\Context;

final readonly class ContextContainerBuilder
{
    public static function build(ContextConfigurator $configurator): ContextContainer
    {
        return new ContextContainer($configurator->all());
    }
}
