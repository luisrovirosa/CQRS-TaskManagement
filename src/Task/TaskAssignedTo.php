<?php

namespace CQRS\Task;

class TaskAssignedTo implements TaskId
{

    /** @var int */
    private $taskId;

    /** @var string */
    private $assignedTo;

    function __construct($taskId, $assignedTo)
    {
        $this->taskId = $taskId;
        $this->assignedTo = $assignedTo;
    }

    /**
     * @return int
     */
    public function taskId()
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function assignedTo()
    {
        return $this->assignedTo;
    }
}
