<?php

namespace CQRS\Task;

interface CommandTaskRepository
{
    /**
     * @param string $name
     */
    public function createTask($name);

    /**
     * @param int $id
     * @param \DateTime $dueDate
     */
    public function schedule($id, \DateTime $dueDate);

    /**
     * @param int $taskId
     */
    public function complete($taskId);

    /**
     * @param int $taskId
     * @param string $userName
     */
    public function assignTo($taskId, $userName);
}
