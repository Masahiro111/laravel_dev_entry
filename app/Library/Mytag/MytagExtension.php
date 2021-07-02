<?php

namespace App\Library\Mytag;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

// use App\Library\Mytag\Accordion;
// use App\Library\Mytag\AccordionParser;
// use App\Library\Mytag\AccordionRenderer;

use App\Library\Mytag\Mytag;
use App\Library\Mytag\MytagParser;
use App\Library\Mytag\MytagRenderer;

class MytagExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new MytagParser(), 1);
        $environment->addBlockRenderer(Mytag::class, new MytagRenderer());
    }
}
