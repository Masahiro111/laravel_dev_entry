<?php

namespace App\Library\MyTaskList;

use League\CommonMark\Block\Element\ListItem;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

final class TaskListItemMarkerParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ['['];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $container = $inlineContext->getContainer();

        if ($container->hasChildren() || !($container instanceof Paragraph && $container->parent() && $container->parent() instanceof ListItem)) {
            return false;
        }

        $cursor = $inlineContext->getCursor();
        $oldState = $cursor->saveState();

        // []の中に「スペース（空白）」か「x」か「X」が入っていれば $mに配列が入力されます
        $m = $cursor->match('/\[[ xX]\]/');
        if ($m === null) {
            return false;
        }

        // もし次のスペースを飛ばした文字がなかったら無効になります
        if ($cursor->getNextNonSpaceCharacter() === null) {
            $cursor->restoreState($oldState);

            return false;
        }

        $isChecked = $m !== '[]';

        $container->appendChild(new TaskListItemMarker($isChecked));

        return true;
    }
}
