<?php

namespace App\Library\Mytag;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

use App\Library\Mytag\Mytag;
use App\Library\Mytag\MytagRenderer;
use App\Library\Mytag\MytagInlineParser;

class MytagExtention implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new MytagInlineParser(), 200);
        $environment->addInlineRenderer(Mytag::class, new MytagRenderer());
    }
}
