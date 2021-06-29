<?php

namespace App\Library\Mytag;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

use App\Library\Mytag\Mytag;

class MytagRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Mytag)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }
        return $inline->element();
    }
}
