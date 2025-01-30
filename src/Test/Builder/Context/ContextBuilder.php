<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context;

use ArchPhp\Assert\Assert;
use ArchPhp\Test\Builder\Context\Accessor\AccessorBuilder;
use ArchPhp\Test\Builder\Context\Assertion\AssertionBuilder;
use ArchPhp\Test\Builder\Context\Type\CollectionBuilder;
use ArchPhp\Test\Builder\Context\Type\Reflection\ClassBuilder;
use ArchPhp\Test\Builder\Context\Type\Reflection\EnumBuilder;
use ArchPhp\Test\Builder\Context\Type\ScalarBuilder;
use Brick\Math\BigInteger;

use function Symfony\Component\String\u;

/**
 * @template T of mixed
 */
abstract class ContextBuilder
{
    /**
     * @param T $value
     */
    final protected function __construct(protected mixed $value) {}

    final public static function scalar(int|string $value): ScalarBuilder
    {
        return new ScalarBuilder(is_int($value) ? BigInteger::of($value) : u($value));
    }

    final public static function class(string $className): ClassBuilder
    {
        Assert::classExists($className, flags: CLASS_FLAG | INTERFACE_FLAG | TRAIT_FLAG);

        return new ClassBuilder(new \ReflectionClass($className));
    }

    final public static function classes(string ...$classNames): CollectionBuilder
    {
        Assert::allClassExists($classNames, flags: CLASS_FLAG | INTERFACE_FLAG | TRAIT_FLAG);

        return new CollectionBuilder(array_map(static fn(string $className): \ReflectionClass => new \ReflectionClass($className), $classNames));
    }

    final public static function enum(string $enumName): EnumBuilder
    {
        Assert::classExists($enumName, flags: ENUM_FLAG);

        return new EnumBuilder(new \ReflectionEnum($enumName));
    }

    final public function assert(string $assertion): AssertionBuilder
    {
        return (new ContextCase($this->value))->assert($assertion);
    }

    final public function access(string $accessor): AccessorBuilder
    {
        return (new ContextCase($this->value))->access($accessor);
    }
}
