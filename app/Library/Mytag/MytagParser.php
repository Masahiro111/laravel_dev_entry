<?php

namespace App\Library\Mytag;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

use App\Library\Mytag\Mytag;

class MytagParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $c = $cursor->getCharacter();
        $cPlus = $cursor->peek();
        if ($c !== "|" and $c !== "+" and $cPlus !== "|" and $cPlus !== "+") {
            // only pipe or plus can start
            return false;
        }

        $startAccordionRegex = "/^\|\+ #{2,6} [[:print:]]+/";
        $accordionStart = $cursor->match($startAccordionRegex);
        if (empty($accordionStart)) {
            return false;
        }
        $accordion = new Mytag($context, $cursor);
        $context->addBlock($accordion);
        return true;
    }
}
