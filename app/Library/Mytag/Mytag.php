<?php

namespace App\Library\Mytag;

use League\CommonMark\Inline\Element\AbstractStringContainer;
use League\CommonMark\HtmlElement;

class Mytag extends AbstractStringContainer
{

    public function isContainer(): bool
    {
        return true;
    }

    public function element()
    {
        $attributes = $this->getData('attributes', []);

        return new HtmlElement('abbr', $attributes, $this->content);
    }
}
