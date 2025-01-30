<?php

declare(strict_types=1);

namespace ArchPhp\Context\Accessor;

use ArchPhp\Assert\Assert;
use ArchPhp\Context\Context;
use ArchPhp\Context\ContextContainer;
use Closure;

use function Symfony\Component\String\u;

abstract class Accessor
{
    protected ContextContainer $container;

    protected function __construct(
        protected readonly string $name,
        protected readonly string $type,
        protected readonly Closure $callback,
        protected readonly bool $memoizable,
    ) {}

    public static function create(string $name, string $type, Closure $callback, bool $memoizable = true): Accessor
    {
        Assert::regex(
            $type,
            '/^(?:[a-z_]+|\b[a-z_]+\|[a-z_]+(?:\|[a-z_]+)*\b|collection\[(?:[a-z_]+|\b[a-z_]+\|[a-z_]+(?:\|[a-z_]+)*\b)\])$/',
        );

        $type = u($type);

        if ([] !== $type->match('/^[a-z_]+$/')) {
            return new NamedAccessor($name, $type->toString(), $callback, $memoizable);
        }

        if ([] !== $type->match('/^[a-z_]+\|[a-z_]+(?:\|[a-z_]+)*$/')) {
            return new UnionAccessor($name, $type->toString(), $callback, $memoizable);
        }

        return new CollectionAccessor($name, $type->toString(), $callback, $memoizable);
    }

    public function compile(ContextContainer $container): void
    {
        $this->container = $container;
    }

    public function isMemoizable(): bool
    {
        return $this->memoizable;
    }

    /**
     * @param array<int|string, mixed> $args
     */
    final public function call(Context $context, array $args): ?Context
    {
        $callback = $this->callback->bindTo($context->getValue());

        $value = $callback(...$args);

        if (null === $value) {
            return null;
        }

        return $this->createContext($value);
    }

    abstract protected function createContext(mixed $value): Context;
}
