<?php

declare(strict_types=1);

namespace ArchPhp\Parser;

use PhpParser\Node;
use PhpParser\ParserFactory;
use Symfony\Component\Finder\SplFileInfo;
use Webmozart\Assert\Assert;

final readonly class PhpParser
{
    /**
     * @return Node[]
     */
    public function parse(SplFileInfo $file): array
    {
        $parser = (new ParserFactory())->createForHostVersion();

        $statements = $parser->parse($file->getContents());

        Assert::notNull($statements);

        return $statements;
    }
}
