<?php

declare(strict_types=1);

namespace ArchPhp\Assert;

use Webmozart\Assert\Assert as WebmozartAssert;

use function ArchPhp\global_class_exists;

final class Assert extends WebmozartAssert
{
    /**
     * @phpstan-assert class-string $value
     */
    public static function classExists($value, $message = '', int $flags = 0): void
    {
        self::string($value);

        $result = global_class_exists($value, $flags);

        parent::true($result, $message);
    }

    /**
     * @phpstan-assert array<class-string> $value
     */
    public static function allClassExists($value, $message = '', int $flags = 0): void
    {
        static::isIterable($value);

        foreach ($value as $v) {
            self::classExists($v, $message, $flags);
        }
    }
}
