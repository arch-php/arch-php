<?php

declare(strict_types=1);

namespace ArchPhp\Test;

abstract class ContextTestCase extends ArchTestCase
{
    final protected function assertAccessor(AccessorCaseBuilder $accessorCaseBuilder): void
    {
        $accessorCase = $accessorCaseBuilder->build($this->getConfig()->getContextContainer());

        $accessedContext = $accessorCase->createContext();

        self::assertSame(
            $accessorCase->getExpectedType(),
            $accessedContext?->guessType() ?? 'null',
            \sprintf(
                'Accessor "%s::%s" must return a "%s"',
                $accessorCase->getContext()->getDefinition()->getId(),
                $accessorCase->getAccessor(),
                $accessorCase->getExpectedType(),
            ),
        );

        self::assertEquals($accessorCase->getExpectedValue(), $accessedContext?->getFormattedValue());
    }

    final protected function assertAssertion(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $assertionCase = $assertionCaseBuilder->build($this->getConfig()->getContextContainer());

        $result = $assertionCase->getResult();

        self::assertSame(
            $assertionCase->getExpectedResult(),
            $result,
            \sprintf(
                'Assertion "%s::%s" must return "%s"',
                $assertionCase->getContext()->getDefinition()->getId(),
                $assertionCase->getAssertion(),
                $assertionCase->getExpectedResult() ? 'true' : 'false',
            ),
        );
    }
}
