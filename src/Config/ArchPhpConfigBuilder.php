<?php

declare(strict_types=1);

namespace ArchPhp\Config;

use ArchPhp\Context\ContextConfigurator;
use ArchPhp\Context\ContextContainerBuilder;
use ArchPhp\Assert\Assert;
use Symfony\Component\Finder\Finder;

final class ArchPhpConfigBuilder
{
    /**
     * @var string[]
     */
    private array $paths = [];

    /**
     * @var string[]
     */
    private array $skipPaths = [];

    private ?string $contextsDir = null;

    public static function configure(): self
    {
        return new self();
    }

    public function setContextsDir(string $contextsDir): self
    {
        Assert::directory($contextsDir);

        $this->contextsDir = $contextsDir;

        return $this;
    }

    /**
     * @param array<array-key, mixed> $paths
     */
    public function withPaths(array $paths): self
    {
        Assert::allString($paths);

        $this->paths = $paths;

        return $this;
    }

    public function skipPath(string $path): self
    {
        $this->skipPaths[] = $path;

        return $this;
    }

    public function build(): ArchPhpConfig
    {
        $contextConfigurator = new ContextConfigurator();

        $contextDirs = [dirname(__DIR__, 2) . '/config/contexts'];

        if ($this->contextsDir !== null) {
            $contextDirs[] = $this->contextsDir;
        }

        $finder = (new Finder())->in($contextDirs)->files()->name('*.php');

        foreach ($finder as $context) {
            $callback = require $context->getRealPath();

            Assert::isCallable($callback);

            $callback($contextConfigurator);
        }

        $contextContainer = ContextContainerBuilder::build($contextConfigurator);

        $contextContainer->compile();

        return new ArchPhpConfig(
            $this->paths,
            $this->skipPaths,
            $contextContainer,
        );
    }
}
