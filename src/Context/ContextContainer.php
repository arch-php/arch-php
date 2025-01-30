<?php

declare(strict_types=1);

namespace ArchPhp\Context;

use ArchPhp\Assert\Assert;
use loophp\collection\Collection;

final class ContextContainer
{
    private bool $compiled = false;

    /**
     * @param array<string, ContextDefinition> $definitions
     */
    public function __construct(private readonly array $definitions) {}

    public function getDefinition(string $id): ContextDefinition
    {
        Assert::keyExists($this->definitions, $id, sprintf('The context "%s" does not exist.', $id));

        return $this->definitions[$id];
    }

    public function hasDefinition(string $id): bool
    {
        return isset($this->definitions[$id]);
    }

    public function compile(): void
    {
        foreach ($this->definitions as $definition) {
            $definition->compile($this);
        }

        $this->compiled = true;
    }

    public function createContext(mixed $value): Context
    {
        Assert::true($this->compiled, 'The container must be compiled before creating a context.');

        foreach ($this->definitions as $definition) {
            if ($definition->supports($value)) {
                return $definition->createContext($value);
            }
        }

        throw new \RuntimeException(sprintf('No context found for value of type "%s".', get_debug_type($value)));
    }

    public function guessType(Context $context): string
    {
        Assert::true($this->compiled, 'The container must be compiled before creating a context.');

        if (!$context->getValue() instanceof Collection) {
            foreach ($this->definitions as $definition) {
                if ($definition->supports($context->getValue())) {
                    return $definition->getId();
                }
            }

            throw new \RuntimeException(sprintf('No context found for value of type "%s".', get_debug_type($context->getValue())));
        }

        if (0 === count($context->getValue())) {
            return 'empty';
        }

        $types = [];

        /** @var iterable<Context> $collection */
        $collection = $context->getValue();

        foreach ($collection as $item) {
            $types[] = $this->guessType($item);
        }

        $types = \array_unique($types);

        sort($types);

        return \sprintf('collection[%s]', \implode('|', $types));
    }
}
