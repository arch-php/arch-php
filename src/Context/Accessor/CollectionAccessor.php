<?php

declare(strict_types=1);

namespace ArchPhp\Context\Accessor;

use ArchPhp\Context\ContextContainer;
use Closure;

use function Symfony\Component\String\u;

final class CollectionAccessor extends NamedAccessor
{
    private readonly Accessor $innerAccessor;

    public function __construct(string $name, string $type, Closure $callback, bool $memoizable)
    {
        parent::__construct($name, $type, $callback, $memoizable);

        /** @var string $innerType */
        ['inner' => $innerType] = u($type)->match('/^collection\[(?<inner>.+)\]$/');

        $this->innerAccessor = Accessor::create($name, $innerType, fn(): static => $this, $memoizable);
    }

    public function compile(ContextContainer $container): void
    {
        $this->container = $container;

        $this->definition = $this->container->getDefinition('collection');

        $this->innerAccessor->compile($container);
    }
}
