<?php

declare(strict_types=1);

namespace ArchPhp\Assert;

use Webmozart\Assert\Assert as WebmozartAssert;

final class Assert extends WebmozartAssert
{
    /**
     * @phpstan-assert class-string $value
     */
    public static function classExists($value, $message = '', bool $acceptEnum = true): void
    {
        self::string($value);

        if ('' === $message) {
            $message = \sprintf('Class "%s" does not exist.', $value);
        }

        parent::true(
            class_exists($value)
            || interface_exists($value)
            || trait_exists($value)
            || ($acceptEnum && enum_exists($value)),
            $message,
        );
    }

    /**
     * @phpstan-assert class-string $value
     */
    public static function enumExists(mixed $value, string $message = ''): void
    {
        self::string($value);

        if ('' === $message) {
            $message = \sprintf('Enum "%s" does not exist.', $value);
        }

        parent::true(enum_exists($value), $message);
    }
}
