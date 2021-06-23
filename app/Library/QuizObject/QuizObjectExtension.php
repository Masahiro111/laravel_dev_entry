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

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use App\Library\QuizObject\QuizObjectParser;

final class QuizObjectExtension implements ExtensionInterface
{
    /**
     * @inheritDoc
     */
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new QuizObjectParser(), 100);
    }
}
