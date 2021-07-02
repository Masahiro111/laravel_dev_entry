<?php

namespace App\Library\Origin;


use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

// use App\Library\Mytag\Accordion;
// use App\Library\Mytag\AccordionParser;
// use App\Library\Mytag\AccordionRenderer;

use App\Library\Origin\OriginBlock;
use App\Library\Origin\OriginParser;
use App\Library\Origin\OriginRenderer;

class OriginExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new OriginParser(), 1);
        $environment->addBlockRenderer(OriginBlock::class, new OriginRenderer());
    }
}
