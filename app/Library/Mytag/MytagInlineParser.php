<?php

namespace App\Library\Mytag;

use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

use App\Library\Mytag\Mytag;

class MytagInlineParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ["["];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $nextChar = $cursor->peek();
        if ($nextChar !== null and $nextChar !== ".") {
            return false;
        }

        $previousCursor = $cursor->saveState();

        $regex = '/^\[\..+?\]\(.+?\)/';
        $abbr = $cursor->match($regex);

        if (empty($abbr)) {
            $cursor->restoreState($previousCursor);
            return false;
        }
        $abbr = substr($abbr, 2);
        $abbr = substr($abbr, 0, -1);
        list($abbr, $title) = explode("](", $abbr, 2);
        $elem = new Mytag($abbr, ['attributes' => ['title' => $title]]);

        $inlineContext->getContainer()->appendChild($elem);

        return true;
    }
}
