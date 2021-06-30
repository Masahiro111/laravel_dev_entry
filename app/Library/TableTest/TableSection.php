<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\AbstractStringContainerBlock;
use League\CommonMark\Block\Element\InlineContainerInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

final class TableSection extends AbstractStringContainerBlock implements InlineContainerInterface
{
    const TYPE_HEAD = 'thead';
    const TYPE_BODY = 'tbody';

    public $type = self::TYPE_BODY;

    public function __construct(string $type = self::TYPE_BODY)
    {
        parent::__construct();
        $this->type = $type;
    }

    public function isHead(): bool
    {
        return self::TYPE_BODY === $this->type;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return $block instanceof TableRow;
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
