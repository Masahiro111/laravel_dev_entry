<?php

namespace App\Library\Origin;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

use App\Library\Origin\OriginBlock;

class OriginParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        // Look for the starting syntax
        if ($cursor->match('/^{{ /')) {
            $id = $cursor->getRemainder();
            $cursor->advanceToEnd();

            $context->addBlock(new OriginBlock($id));

            return true;
            // Look for the ending syntax
        } elseif ($cursor->match('/^}} +$/')) {
            // TODO: I don't know if this is the best approach, but it should work
            // Basically, we're going to locate a parent ObjectBlock in the AST...
            $container = $context->getContainer();
            while ($container) {
                if ($container instanceof OriginBlock) {
                    $cursor->advanceToEnd();

                    // Found it!  Now we'll close everything up to (and including) it
                    $context->getBlockCloser()->setLastMatchedContainer($container->parent());
                    $context->getBlockCloser()->closeUnmatchedBlocks();
                    $context->setBlocksParsed(true);

                    return true;
                }

                $container = $container->parent();
            }
        }

        return false;
    }
}
