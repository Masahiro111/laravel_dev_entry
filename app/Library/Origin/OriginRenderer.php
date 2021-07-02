<?php

namespace App\Library\Origin;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;

class OriginRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        // $span = sprintf('<span>%s</span>', $block->getObjectId());
        $span = sprintf('<span>a</span>');
        $contents = $htmlRenderer->renderBlocks($block->children());

        return new HtmlElement(
            'div',
            ['class' => 'object'],
            $span . $contents
        );
    }
}
