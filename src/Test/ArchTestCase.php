<?php

declare(strict_types=1);

namespace ArchPhp\Test;

use ArchPhp\Config\ArchPhpConfig;
use ArchPhp\Config\ArchPhpConfigBuilder;
use ArchPhp\Context\Context;
use ArchPhp\Context\ContextDefinition;
use PHPUnit\Framework\TestCase;

abstract class ArchTestCase extends TestCase
{
    private ArchPhpConfig $config;

    final protected function setUp(): void
    {
        $this->config = $this->initialize(ArchPhpConfigBuilder::configure());
    }

    protected function initialize(ArchPhpConfigBuilder $configBuilder): ArchPhpConfig
    {
        return $configBuilder
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
            ->build();
    }

    final protected function createContext(string $context, mixed $value): Context
    {
        return $this->getContext($context)->createContext($value);
    }

    final protected function getConfig(): ArchPhpConfig
    {
        return $this->config;
    }

    final protected function getContext(string $name): ContextDefinition
    {
        return $this->config->getContextContainer()->getDefinition($name);
    }
}
