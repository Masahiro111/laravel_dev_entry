<?php

namespace App\Library\Markup;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

use App\Library\Markup\Markup;

class MarkupParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $c = $cursor->getCharacter();
        $cPlus = $cursor->peek();
        $cDouble = $c . $cPlus;
        if ($cDouble !== ">>") {
            // only ">" can start
            return false;
        }

        $regex = "/^\>\>\s(.*?)\s\<\</";
        // ddd($startAccordionRegex);
        $result = $cursor->match($regex);
        if (empty($result)) {
            return false;
        }
        $accordion = new Markup($context, $cursor);
        $context->addBlock($accordion);
        // ddd($accordion);

        return true;
    }
}
