<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Accessor;

use ArchPhp\Test\Builder\Context\ContextCase;

final class AccessorBuilder
{
    /**
     * @var array<string, mixed>
     */
    private array $arguments = [];

    public function __construct(private readonly ContextCase $contextCase, private readonly string $accessor) {}

    public function withArgument(string $name, mixed $argument): self
    {
        $this->arguments[$name] = $argument;
        return $this;
    }

    private function shouldBe(string $type, mixed $value): ContextCase
    {
        return $this->contextCase->addAccessor(
            new AccessorCase(
                $this->accessor,
                $this->arguments,
                $type,
                $value,
            ),
        );
    }

    public function shouldBeClass(string $class): ContextCase
    {
        return $this->shouldBe('class', $class);
    }

    public function shouldBeEnum(string $enum): ContextCase
    {
        return $this->shouldBe('enum', $enum);
    }

    public function shouldBeAttribute(string $attribute): ContextCase
    {
        return $this->shouldBe('attribute', $attribute);
    }

    public function shouldBeEnumCase(string $case): ContextCase
    {
        return $this->shouldBe('enum_case', $case);
    }

    public function shouldBeClassConstant(string $constant): ContextCase
    {
        return $this->shouldBe('class_constant', $constant);
    }

    public function shouldBeMethod(string $method): ContextCase
    {
        return $this->shouldBe('method', $method);
    }

    public function shouldBeProperty(string $property): ContextCase
    {
        return $this->shouldBe('property', $property);
    }

    public function shouldBeParameter(string $parameter): ContextCase
    {
        return $this->shouldBe('parameter', $parameter);
    }

    public function shouldBeType(string $type): ContextCase
    {
        return $this->shouldBe('type', $type);
    }

    public function shouldBeNull(): ContextCase
    {
        return $this->shouldBe('null', null);
    }

    public function shouldBeEmpty(): ContextCase
    {
        return $this->shouldBe('empty', []);
    }

    /**
     * @param array<int, mixed> $items
     */
    public function shouldBeCollectionOf(string $innerType, array $items): ContextCase
    {
        return $this->shouldBe(\sprintf('collection[%s]', $innerType), $items);
    }

    public function shouldBeString(string $value): ContextCase
    {
        return $this->shouldBe('string', $value);
    }

    public function shouldBeNumber(int $value): ContextCase
    {
        return $this->shouldBe('number', $value);
    }
}
