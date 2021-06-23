<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\AbstractStringContainerBlock;
use League\CommonMark\Block\Element\InlineContainerInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Extension\Table\TableSection;

final class Table extends AbstractStringContainerBlock implements InlineContainerInterface
{
    private $head;
    private $body;
    private $parser;

    public function __construct(\Closure $parser)
    {
        parent::__construct();
        $this->appendChild($this->head = new TableSection(TableSection::TYPE_HEAD));
        $this->appendChild($this->body = new TableSection(TableSection::TYPE_BODY));
        $this->parser = $parser;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return $block instanceof TableSection;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function getHead(): TableSection
    {
        return $this->head;
    }

    public function getBody(): TableSection
    {
        return $this->body;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return call_user_func($this->parser, $cursor, $this);
    }

    public function handleRemainingContents(ContextInterface $context, Cursor $cursor)
    {
    }
}
