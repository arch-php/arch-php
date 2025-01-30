<?php

declare(strict_types=1);

namespace ArchPhp\Test;

abstract class ContextTestCase extends ArchTestCase
{
    abstract public function testContext(): void; // @codeCoverageIgnore
}
