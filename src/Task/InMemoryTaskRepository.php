<?php

namespace CQRS\Task;

class InMemoryTaskRepository implements TaskRepository
{

    private $tasks;

    function __construct()
    {
        $this->tasks = [];
    }

    /**
     * @param string $name
     */
    public function createTask($name)
    {
        $this->tasks[] = new Task($name);
    }

    /**
     * @return Task[]
     */
    public function findAll()
    {
        return $this->tasks;
    }
}
