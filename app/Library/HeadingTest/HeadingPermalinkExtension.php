<?php

namespace App\Library\HeadingTest;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ExtensionInterface;

// use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;

final class HeadingPermalinkExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addEventListener(DocumentParsedEvent::class, new HeadingPermalinkRenderer(), -100);
        $environment->addInlineRenderer(HeadingPermalink::class, new HeadingPermalinkRenderer());
    }
}
