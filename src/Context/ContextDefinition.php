<?php

declare(strict_types=1);

namespace ArchPhp\Context;

use ArchPhp\Assert\Assert;
use ArchPhp\Context\Accessor\Accessor;
use Closure;

final class ContextDefinition
{
    private ContextContainer $container;

    private ?Closure $initializer = null;

    /**
     * @var array<string, Accessor>
     */
    private array $accessors = [];

    /**
     * @var array<string, Assertion>
     */
    private array $assertions = [];

    /**
     * @var null|Closure(mixed): mixed
     */
    private ?Closure $formatter = null;

    /**
     * @var null|Closure(mixed): bool
     */
    private ?Closure $voter = null;

    public function __construct(private string $id, private int $priority) {}

    public function supports(mixed $value): bool
    {
        Assert::notNull($this->voter, sprintf('The voter for the context "%s" is not defined.', $this->id));

        return ($this->voter)($value);
    }

    public function setVoter(Closure $voter): self
    {
        $this->voter = $voter;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setFormatter(Closure $formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function setInitializer(Closure $initializer): self
    {
        $this->initializer = $initializer;

        return $this;
    }

    public function addAccessor(string $name, string $type, Closure $callback, bool $memoizable = true): self
    {
        Assert::keyNotExists($this->assertions, $name, sprintf('An assertion "%s" already exists.', $name));
        Assert::keyNotExists($this->accessors, $name, sprintf('The accessor "%s" already exists.', $name));

        $this->accessors[$name] = Accessor::create($name, $type, $callback, $memoizable);

        return $this;
    }

    public function addAssertion(string $name, Closure $callback): self
    {
        Assert::keyNotExists($this->accessors, $name, sprintf('An accessor "%s" already exists.', $name));
        Assert::keyNotExists($this->assertions, $name, sprintf('The assertion "%s" already exists.', $name));

        $this->assertions[$name] = new Assertion($callback);

        return $this;
    }

    public function compile(ContextContainer $container): void
    {
        $this->container = $container;

        Assert::notNull($this->formatter, sprintf('The formatter for the context "%s" is not defined.', $this->id));
        Assert::notNull($this->voter, sprintf('The voter for the context "%s" is not defined.', $this->id));

        foreach ($this->accessors as $accessor) {
            $accessor->compile($this->container);
        }
    }

    public function format(Context $context): mixed
    {
        Assert::notNull($this->formatter, sprintf('The formatter for the context "%s" is not defined.', $this->id));

        return ($this->formatter)($context->getValue());
    }

    public function createContext(mixed $value): Context
    {
        if ($this->initializer instanceof \Closure) {
            $value = ($this->initializer)($value, $this->container);
        }

        Assert::object($value, sprintf('The value must be an object, got "%s".', get_debug_type($value)));

        return new Context($this, $value);
    }

    public function getAccessor(string $name): Accessor
    {
        Assert::keyExists($this->accessors, $name, sprintf('The accessor "%s" does not exist.', $name));

        return $this->accessors[$name];
    }

    public function getAssertion(string $name): Assertion
    {
        Assert::keyExists($this->assertions, $name, sprintf('The assertion "%s" does not exist.', $name));

        return $this->assertions[$name];
    }

    public function guessType(Context $context): string
    {
        return $this->container->guessType($context);
    }

    /**
     * @return array<string, Accessor>
     */
    public function getAccessors(): array
    {
        return $this->accessors;
    }

    /**
     * @return array<string, Assertion>
     */
    public function getAssertions(): array
    {
        return $this->assertions;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
