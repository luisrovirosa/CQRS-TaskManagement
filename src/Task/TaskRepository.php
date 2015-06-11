<?php

namespace CQRS\Task;

interface TaskRepository
{
    /**
     * @param string $name
     */
    public function createTask($name);

    /**
     * @return TaskDTO[]
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

    /**
     * @param $userName
     * @return TaskDTO[]
     */
    public function findTasksAssignedTo($userName);

    public function assignTo($taskId, $userName);
}
