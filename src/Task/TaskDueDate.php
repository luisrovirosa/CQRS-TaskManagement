<?php

namespace CQRS\Task;

class TaskDueDate
{
    /** @var  int */
    private $taskId;

    /** @var  \DateTime */
    private $dueDate;

    function __construct($taskId, $dueDate)
    {
        $this->taskId = $taskId;
        $this->dueDate = $dueDate;
    }

    public function taskId()
    {
        return $this->taskId;
    }

    public function dueDate()
    {
        return $this->dueDate;
    }
}
