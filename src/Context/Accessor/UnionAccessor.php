<?php

declare(strict_types=1);

namespace ArchPhp\Context\Accessor;

use ArchPhp\Context\Context;
use ArchPhp\Context\ContextContainer;
use Closure;

final class UnionAccessor extends Accessor
{
    /**
     * @var array<string, NamedAccessor>
     */
    private readonly array $accessors;

    public function __construct(string $name, string $type, Closure $callback, bool $memoizable)
    {
        parent::__construct($name, $type, $callback, $memoizable);

        $accessors = [];

        foreach (explode('|', $type) as $subType) {
            $accessors[$subType] = new NamedAccessor($name, $subType, $callback, $memoizable);
        }

        $this->accessors = $accessors;
    }

    public function compile(ContextContainer $container): void
    {
        foreach ($this->accessors as $accessor) {
            $accessor->compile($container);
        }
    }

    protected function createContext(mixed $value): Context
    {
        return $this->guessAccessor($value)->getDefinition()->createContext($value);
    }

    private function guessAccessor(mixed $value): NamedAccessor
    {
        foreach ($this->accessors as $accessor) {
            if ($accessor->getDefinition()->supports($value)) {
                return $accessor;
            }
        }

        throw new \InvalidArgumentException('No accessor found'); // @codeCoverageIgnore
    }
}
