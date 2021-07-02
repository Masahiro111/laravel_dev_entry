<?php

namespace App\Library\Mytag;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;

class MytagRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof Mytag)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }
        return $block->element($htmlRenderer);
    }
}
