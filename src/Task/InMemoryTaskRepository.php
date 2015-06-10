<?php

namespace CQRS\Task;

use CQRS\Task\Task;

class InMemoryTaskRepository implements TaskRepository
{

    /**
     * @param string $name
     */
    public function createTask($name)
    {
        // TODO: Implement createTask() method.
    }

    /**
     * @return Task[]
     */
    public function findAll()
    {
        return array('');
    }
}
