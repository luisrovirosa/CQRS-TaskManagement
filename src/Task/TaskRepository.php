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
}
