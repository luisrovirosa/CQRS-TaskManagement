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
     * @param int $id
     */
    public function complete($id);
}
