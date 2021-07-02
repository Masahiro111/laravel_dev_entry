<?php

namespace App\Library\Origin;

use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Environment;

use League\CommonMark\Renderer\Block\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;


class ObjectBlock extends AbstractBlock
{
    private $objectId;

    public function __construct($objectId)
    {
        $this->objectId = $objectId;
    }

    public function getObjectId()
    {
        return $this->objectId;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return true;
    }

    public function acceptsLines()
    {
        return false;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return true;
    }
}
