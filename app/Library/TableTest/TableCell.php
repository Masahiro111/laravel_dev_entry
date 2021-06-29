<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\AbstractStringContainerBlock;
use League\CommonMark\Block\Element\InlineContainerInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

final class TableCell extends AbstractStringContainerBlock implements InlineContainerInterface
{
    const TYPE_HEAD = 'th';
    const TYPE_BODY = 'td';

    const ALIGN_LEFT = 'left';
    const ALIGN_RIGHT = 'right';
    const ALIGN_CENTER = 'center';

    public $typ = self::TYPE_BODY;

    public $align;

    public function __construct(string $string = '', string $type = self::TYPE_BODY, string $align = null)
    {
        parent::__construct();
        $this->finalStringContents = $string;
        $this->addLine($string);
        $this->type = $type;
        $this->align = $align;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return false;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return false;
    }

    public function handleRemainingContents(ContextInterface $context, Cursor $cursor)
    {
    }
}
