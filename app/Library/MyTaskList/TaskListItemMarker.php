<?php

namespace App\Library\MyTaskList;

use League\CommonMark\Inline\Element\AbstractInline;

final class TaskListItemMarker extends AbstractInline
{
    protected $checked = false;

    public function __construct(bool $isCompleted)
    {
        $this->checked = $isCompleted;
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }
}
