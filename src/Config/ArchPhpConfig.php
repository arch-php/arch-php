<?php

declare(strict_types=1);

namespace ArchPhp\Config;

use ArchPhp\Context\ContextContainer;
use ArchPhp\Rule\Rule;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class ArchPhpConfig
{
    /**
     * @var null|iterable<string, SplFileInfo>
     */
    private ?iterable $files = null;

    /**
     * @param Rule[] $rules
     * @param string[] $paths
     * @param string[] $skipPaths
     */
    public function __construct(
        private readonly array $rules,
        private readonly array $paths,
        private readonly array $skipPaths,
        private readonly ContextContainer $contextContainer,
    ) {}

    public function getContextContainer(): ContextContainer
    {
        return $this->contextContainer;
    }

    /**
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @return iterable<string, SplFileInfo>
     */
    public function getFiles(): iterable
    {
        if ($this->files === null) {
            $excludedFiles = iterator_to_array(
                (new Finder())
                    ->in($this->skipPaths)
                    ->files()
                    ->sortByName(),
            );

            $this->files = (new Finder())
                ->in($this->paths)
                ->files()
                ->sortByName()
                ->filter(static fn(SplFileInfo $file): bool => !isset($excludedFiles[$file->getRealPath()]));
        }

        yield from $this->files;
    }
}
