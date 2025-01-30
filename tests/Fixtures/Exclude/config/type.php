<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->get('type')
        ->addAssertion('fake', fn(): bool => true)
    ;
};
