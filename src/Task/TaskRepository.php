<?php

namespace CQRS\Task;

interface TaskRepository
{
    /**
     * @param string $name
     */
    public function createTask($name);

    /**
     * @return Task[]
     */
    public function findAll();

    /**
     * @param int $id
     * @param \DateTime $dueDate
     */
    public function schedule($id, \DateTime $dueDate);

    /**
     * @param int $taskId
     */
    public function complete($taskId);

    public function findTasksAssignedTo($userName);

    public function assignTo($taskId, $userName);
}
