<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use Facade\Ignition\Tabs\Tab;
use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\Context;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\EnvironmentAwareInterface;
use League\CommonMark\EnvironmentInterface;
// use League\CommonMark\Extension\Table\TableCell;
// use League\CommonMark\Extension\Table\TableRow;

use App\Library\TableTest\TableCell;
use App\Library\TableTest\TableRow;



final class TableParser implements BlockParserInterface, EnvironmentAwareInterface
{
    private $environment;

    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $container = $context->getContainer();
        if (!$container instanceof Paragraph) {
            return false;
        }

        $lines = $container->getStrings();
        if (count($lines) === 0) {
            return false;
        }

        $lastLine = \array_pop($lines);
        if (\strpos($lastLine, '|') === false) {
            return false;
        }

        $oldState = $cursor->saveState();
        $cursor->advanceToNextNonSpaceOrTab();
        $columns = $this->parseColumns($cursor);

        if (empty($columns)) {
            $cursor->restoreState($oldState);

            return false;
        }

        $head = $this->parseRow(trim((string) $lastLine), $columns, TableCell::TYPE_HEAD);
        if (null === $head) {
            $cursor->restoreState($oldState);

            return false;
        }

        $table = new Table(function (Cursor $cursor, Table $table) use ($columns): bool {
            if (self::isANewBlock($this->enviroment, $cursor->getLine())) {
                return false;
            }

            $row = $this->parseRow(\trim($cursor->getLine()), $columns);
            if (null === $row) {
                return false;
            }

            $table->getBody()->appendChild($row);

            return true;
        });

        $table->getHead()->appendChild($head);

        if (count($lines) >= 1) {
            $paragraph = new Paragraph();
            foreach ($lines as $line) {
                $paragraph->addLine($line);
            }

            $context->replaceContainerBlock($paragraph);
            $context->addBlock($table);
        } else {
            $context->replaceContainerBlock($table);
        }

        return true;
    }

    private function parseRow(string $line, array $columns, string $type = TableCell::TYPE_BODY): ?TableRow
    {
        $cells = $this->split(new Cursor(\trim($line)));

        if (empty($cells)) {
            return null;
        }

        if ($type === TableCell::TYPE_HEAD && \count($cells) !== \count($columns)) {
            return null;
        }

        $i = 0;
        $row = new TableRow();
        foreach ($cells as $i => $cell) {
            if (!array_key_exists($i, $columns)) {
                return $row;
            }

            $row->appendChild(new TableCell(trim($cell), $type, $columns[$i]));
        }

        for ($j = count($columns) - 1; $j > $i; --$j) {
            $row->appendChild(new TableCell('', $type, null));
        }

        return $row;
    }

    private function split(Cursor $cursor): array
    {
        if ($cursor->getCharacter() === '|') {
            $cursor->advanceBy(1);
        }

        $cells = [];
        $sb = '';

        while (!$cursor->isAtEnd()) {
            switch ($c = $cursor->getCharacter()) {
                case '\\':
                    if ($cursor->peek() === '|') {
                        $sb .= '|';
                        $cursor->advanceBy(1);
                    } else {
                        $sb .= '\\';
                    }
                    break;
                case '|':
                    $cells[] = $sb;
                    $sb = '';
                    break;
                default:
                    $sb .= $c;
            }
            $cursor->advanceBy(1);
        }

        if ($sb !== '') {
            $cells[] = $sb;
        }
        return $cells;
    }

    private function parseColumns(Cursor $cursor): array
    {
        $columns = [];
        $pipes = 0;
        $valid = false;

        while (!$cursor->isAtEnd()) {
            switch ($c = $cursor->getCharacter()) {
                case '|':
                    $cursor->advanceBy(1);
                    $pipes++;
                    if ($pipes > 1) {
                        return [];
                    }

                    $valid = true;
                    break;
                case '-':
                case ':':
                    if ($pipes === 0 && !empty($columns)) {
                        return [];
                    }
                    $left = false;
                    $right = false;
                    if ($c === ':') {
                        $left = true;
                        $cursor->advanceBy(1);
                    }
                    if ($cursor->match('/^-+/') === null) {
                        return [];
                    }
                    if ($cursor->getCharacter() === ':') {
                        $right = true;
                        $cursor->advanceBy(1);
                    }
                    $columns[] = $this->getAlignment($left, $right);
                    $pipes = 0;
                    break;
                case ' ':
                case "\t":
                    $cursor->advanceToNextNonSpaceOrTab();
                    break;
                default:
                    return [];
            }
        }
        if (!$valid) {
            return [];
        }
        return $columns;
    }

    private static function getAlignment(bool $left, bool $right): ?string
    {
        if ($left && $right) {
            return TableCell::ALIGN_CENTER;
        } elseif ($left) {
            return TableCell::ALIGN_LEFT;
        } elseif ($right) {
            return TableCell::ALIGN_RIGHT;
        }

        return null;
    }

    public function setEnvironment(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }

    private static function isANewBlock(EnvironmentInterface $environment, string $line)
    {
        $context = new Context(new Document(), $environment);
        $context->setNextLine($line);
        $cursor = new Cursor($line);

        foreach ($environment->getBlockParsers() as $parser) {
            if ($parser->parse($context, $cursor)) {
                return true;
            }
        }

        return false;
    }
}
