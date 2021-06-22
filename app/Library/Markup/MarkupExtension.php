<?php

namespace App\Library\Markup;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

use App\Library\Markup\Markup;
use App\Library\Markup\MarkupParser;
use App\Library\Markup\MarkupRenderer;

class MarkupExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new MarkupParser(), 100);
        $environment->addBlockRenderer(Markup::class, new MarkupRenderer());
    }
}
