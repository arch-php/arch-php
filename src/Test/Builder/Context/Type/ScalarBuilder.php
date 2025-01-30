<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Type;

use ArchPhp\Test\Builder\Context\ContextBuilder;
use Brick\Math\BigInteger;
use Symfony\Component\String\UnicodeString;

/**
 * @extends ContextBuilder<BigInteger|UnicodeString>
 */
final class ScalarBuilder extends ContextBuilder {}
