<?php

declare(strict_types=1);


namespace App\Library\TableTest;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class TableSectionRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!$block instanceof TableSection) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        if (!$block->hasChildren()) {
            return '';
        }

        $attrs = $block->getData('attributes', []);

        $separator = $htmlRenderer->getOption('inner_separator', "\n");

        return new HtmlElement($block->type, $attrs, $separator . $htmlRenderer->renderBlocks($block->children()) . $separator);
    }
}
