<?php

namespace CQRS\Task;

class InMemoryTaskRepository implements TaskRepository
{
    /** @var Task[] */
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
        $this->tasks[] = new Task($this->generateId(), $name);
    }

    /**
     * @return TaskDTO[]
     */
    public function findAll()
    {
        return array_map(
            function (Task $task) {
                return new TaskDTO($task->id(), $task->name());
            },
            $this->tasks
        );
    }

    /**
     * @return int
     */
    private function generateId()
    {
        return count($this->tasks) + 1;
    }
}
