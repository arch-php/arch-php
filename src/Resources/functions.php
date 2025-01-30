<?php

declare(strict_types=1);

namespace ArchPhp;

define('CLASS_FLAG', 1);
define('INTERFACE_FLAG', 2);
define('TRAIT_FLAG', 4);
define('ENUM_FLAG', 8);
define('CLASS_FLAGS', [
    'class' => CLASS_FLAG,
    'interface' => INTERFACE_FLAG,
    'trait' => TRAIT_FLAG,
    'enum' => ENUM_FLAG,
]);

if (!\function_exists('ArchPhp\global_class_exists')) {
    /**
     * @phpstan-assert class-string $className
     */
    function global_class_exists(string $className, int $flags = 0): bool
    {
        $classFlag = class_flag($className);

        if (0 === $classFlag) {
            return false;
        }

        if ($flags === 0) {
            return true;
        }

        return ($classFlag & $flags) > 0;
    }

    function class_flag(string $className): int
    {
        $isClass = class_exists($className);
        $isInterface = interface_exists($className);
        $isTrait = trait_exists($className);
        $isEnum = enum_exists($className);

        if (!($isClass || $isInterface || $isTrait || $isEnum)) {
            return 0;
        }

        return match (true) {
            $isInterface => INTERFACE_FLAG,
            $isTrait => TRAIT_FLAG,
            $isEnum => ENUM_FLAG,
            default => CLASS_FLAG,
        };
    }
}
