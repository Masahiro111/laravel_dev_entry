<?php
/*
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2020 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

declare(strict_types=1);

namespace App\Library\QuizObject;

use League\CommonMark\Inline\Element\Text;
use League\CommonMark\Inline\Element\HtmlInline;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

final class QuizObjectParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ['('];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();

        // The symbol must not have any other characters immediately prior
        $previousChar = $cursor->peek(-1);
        if ($previousChar !== null && $previousChar !== ' ') {
            // peek() doesn't modify the cursor, so no need to restore state first
            return false;
        }

        // Save the cursor state in case we need to rewind and bail
        $previousState = $cursor->saveState();

        // Advance past the symbol to keep parsing simpler
        $cursor->advance();

        // Parse the emoji match value
        // $identifier = $cursor->match("/^ \) (.)*/");
        $identifier = $cursor->getLine();
        if ($identifier) {
            // $identifier = substr($identifier, 0, -1);
            // $identifier = preg_grep('/\s?\) .+?\n/', [$identifier]);
            // $identifier = implode("\n", $identifier[1]);
            // foreach ($identifier as $data) {
            //     $identifier = '<div class=" p-4 w-max bg-gray-100">' . $data  . '</div>';
            // }
        }
        if ($identifier === null) {
            // Regex failed to match; this isn't a valid emoji
            $cursor->restoreState($previousState);

            return false;
        }


        // if (!array_key_exists($identifier, QuizObject::$codes)) {
        //     $cursor->restoreState($previousState);

        //     return false;
        // }

        // $inlineContext->getContainer()->appendChild(new Text(QuizObject::$codes[$identifier]));
        $inlineContext->getContainer()->appendChild(new HtmlInline($identifier));

        return true;
    }
}
