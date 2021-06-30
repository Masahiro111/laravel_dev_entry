<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class TableCellRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!$block instanceof TableCell) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $attrs = $block->getData('attributes', []);

        if ($block->align !== null) {
            $attrs['align'] = $block->align;
        }

        return new HtmlElement($block->type, $attrs, $htmlRenderer->renderInlines($block->children()));
    }
}
