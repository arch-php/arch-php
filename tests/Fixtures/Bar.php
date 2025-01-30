<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Fixtures;

abstract class Bar implements Baz
{
    protected const PLUGH = 'plugh';

    protected Bar $grault;

    public function bar(): void {}

    public static function baz(): void {}

    protected function qux(): void {}

    protected static function quux() {}

    abstract public function waldo(string $bar): void;

    abstract protected static function xyzzy($foo): void;
}
