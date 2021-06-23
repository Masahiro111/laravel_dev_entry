<?php

declare(strict_types=1);

namespace App\Library\TableTest;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\Table\TableParser;
use League\CommonMark\Extension\Table\TableRenderer;

final class TableExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
        ->addBlockParser(new TableParser())

        ->addBlockRenderer(Table::class, new TableRenderer())
        ->addBlockRenderer()
    }
}