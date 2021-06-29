<?php

declare(strict_types=1);


namespace App\Library\TableTest;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Cursor;
use League\CommonMark\Node\Node;

final class TableRow extends AbstractBlock
{
    public function canContain(AbstractBlock $block): bool
    {
        return $block instanceof TableCell;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return false;
    }

    public function children(): iterable
    {
        return array_filter((array) parent::children(), static function (Node $child): bool {
            return $child instanceof AbstractBlock;
        });
    }
}
