<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class TableExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockParser(new TableParser())

            ->addBlockRenderer(Table::class, new TableRenderer())
            ->addBlockRenderer(TableSection::class, new TableSectionRenderer())
            ->addBlockRenderer(TableRow::class, new TableRowRenderer())
            ->addBlockRenderer(TableCell::class, new TableCellRenderer());
    }
}
