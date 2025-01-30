<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Type;

use ArchPhp\Test\Builder\Context\ContextBuilder;

/**
 * @template T of object
 * @extends ContextBuilder<T>
 */
abstract class ReflectionBuilder extends ContextBuilder {}
