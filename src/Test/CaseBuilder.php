<?php

declare(strict_types=1);

namespace ArchPhp\Test;

abstract class CaseBuilder
{
    private function __construct(protected mixed $value) {}

    /**
     * @param class-string $class
     */
    public static function createClass(string $class): static
    {
        return new static(new \ReflectionClass($class));
    }

    /**
     * @param class-string $class
     */
    public static function createProperty(string $class, string $property): static
    {
        return new static(new \ReflectionProperty($class, $property));
    }

    /**
     * @param class-string $class
     */
    public static function createMethod(string $class, string $method): static
    {
        return new static(new \ReflectionMethod($class, $method));
    }

    /**
     * @param class-string $class
     */
    public static function createEnum(string $class): static
    {
        return new static(new \ReflectionEnum($class));
    }

    /**
     * @param class-string $class
     */
    public static function createClassConstant(string $class, string $constant): static
    {
        return new static(new \ReflectionClassConstant($class, $constant));
    }

    /**
     * @param class-string $class
     */
    public static function createEnumCase(string $class, string $case): static
    {
        return new static((new \ReflectionEnum($class))->getCase($case));
    }

    /**
     * @param class-string $class
     * @param class-string $attribute
     */
    public static function createClassAttribute(string $class, string $attribute): static
    {
        return new static((new \ReflectionClass($class))->getAttributes($attribute)[0]);
    }

    /**
     * @param class-string $class
     */
    public static function createParameter(string $class, string $method, string $parameter): static
    {
        $parameters = (new \ReflectionMethod($class, $method))->getParameters();

        $parameters = array_combine(
            array_map(static fn(\ReflectionParameter $parameter): string => $parameter->getName(), $parameters),
            $parameters,
        );

        return new static($parameters[$parameter]);
    }

    /**
     * @param class-string $class
     */
    public static function createPropertyType(string $class, string $property): static
    {
        return new static((new \ReflectionProperty($class, $property))->getType());
    }

    public static function createScalar(int|string $value): static
    {
        return new static($value);
    }

    /**
     * @param array<class-string> $classes
     */
    public static function createClassCollection(array $classes): static
    {
        return new static(array_map(static fn(string $class): \ReflectionClass => new \ReflectionClass($class), $classes));
    }
}
