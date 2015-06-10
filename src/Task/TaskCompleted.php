<?php

namespace CQRS\Task;

class TaskCompleted
{
    /** @var  int */
    private $taskId;

    /** @var \DateTime */
    private $completedOn;

    function __construct($taskId)
    {
        $this->taskId = $taskId;
        $this->completedOn = new \DateTime();
    }

    public function taskId()
    {
        return $this->taskId;
    }

    public function completedOn()
    {
        return $this->completedOn;
    }
}
