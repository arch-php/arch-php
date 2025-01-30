<?php

declare(strict_types=1);

namespace ArchPhp\Test;

use ArchPhp\Config\ArchPhpConfig;
use ArchPhp\Config\ArchPhpConfigBuilder;
use ArchPhp\Context\Context;
use ArchPhp\Test\Builder\Context\Accessor\AccessorCase;
use ArchPhp\Test\Builder\Context\Assertion\AssertionCase;
use ArchPhp\Test\Builder\Context\ContextCase;
use PHPUnit\Framework\TestCase;

abstract class ArchTestCase extends TestCase
{
    private ArchPhpConfig $config;

    final protected function setUp(): void
    {
        $this->config = $this->initialize(ArchPhpConfigBuilder::configure());
    }

    protected function initialize(ArchPhpConfigBuilder $configBuilder): ArchPhpConfig
    {
        return $configBuilder
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
            ->build();
    }

    final protected function createContext(mixed $value): Context
    {
        return $this->config->getContextContainer()->createContext($value);
    }

    final protected function assertContext(ContextCase $contextCase): void
    {
        $context = $this->createContext($contextCase->getValue());

        $testedAccessors = [];

        foreach ($contextCase->getAccessors() as $accessorCase) {
            $this->assertAccessor($context, $accessorCase);
            $testedAccessors[$accessorCase->getAccessor()] = $accessorCase->getAccessor();
        }

        $testedAssertions = [];

        foreach ($contextCase->getAssertions() as $assertionCase) {
            $this->assertAssertion($context, $assertionCase);
            $testedAssertions[$assertionCase->getAssertion()] = $assertionCase->getAssertion();
        }

        $expectedAccessors = array_keys($context->getDefinition()->getAccessors());
        $missingAccessors = array_diff($expectedAccessors, array_keys($testedAccessors));

        self::assertCount(
            0,
            $missingAccessors,
            \sprintf(
                'You should test all accessors of "%s" context. Missing: %s',
                $context->getDefinition()->getId(),
                implode(', ', $missingAccessors),
            ),
        );

        $expectedAssertions = array_keys($context->getDefinition()->getAssertions());
        $missingAssertions = array_diff($expectedAssertions, array_keys($testedAssertions));

        self::assertCount(
            0,
            $missingAssertions,
            \sprintf(
                'You should test all assertions of "%s" context. Missing: %s',
                $context->getDefinition()->getId(),
                implode(', ', $missingAssertions),
            ),
        );

    }

    final protected function assertAccessor(Context $context, AccessorCase $accessorCase): void
    {
        $accessedContext = $context->access($accessorCase->getAccessor(), $accessorCase->getArguments());

        self::assertSame(
            $accessorCase->getExpectedType(),
            $accessedContext?->guessType() ?? 'null',
            \sprintf(
                'Accessor "%s::%s" must return a "%s"',
                $context->getDefinition()->getId(),
                $accessorCase->getAccessor(),
                $accessorCase->getExpectedType(),
            ),
        );

        self::assertEquals($accessorCase->getExpectedValue(), $accessedContext?->getFormattedValue());
    }

    final protected function assertAssertion(Context $context, AssertionCase $assertionCase): void
    {
        $result = $context->assert($assertionCase->getAssertion(), $assertionCase->getArguments());

        self::assertSame(
            $assertionCase->getExpectedResult(),
            $result,
            \sprintf(
                'Assertion "%s::%s" must return "%s"',
                $context->getDefinition()->getId(),
                $assertionCase->getAssertion(),
                $assertionCase->getExpectedResult() ? 'true' : 'false',
            ),
        );
    }
}
