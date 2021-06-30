<?php

namespace App\Library\MyTaskList;


use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class TaskListExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new TaskListItemMarkerParser(), 35);
        $environment->addInlineRenderer(TaskListItemMarker::class, new TaskListItemMarkerRenderer());
    }
}
