<?php

namespace CQRS\Task;

class InMemoryTaskRepository implements TaskRepository
{
    /** @var Task[] */
    private $tasks;

    /** @var  TaskDueDate[] */
    private $taskDueDate;

    function __construct()
    {
        $this->tasks = [];
        $this->taskDueDate = [];
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
                $dueDate = $this->findDueDateFor($task);

                return new TaskDTO($task->id(), $task->name(), $dueDate);
            },
            $this->tasks
        );
    }

    /**
     * @param int $id
     * @param \DateTime $dueDate
     */
    public function schedule($id, \DateTime $dueDate)
    {
        $this->taskDueDate[] = new TaskDueDate($id, $dueDate);
    }


    // ------------------------ Helpers --------------
    /**
     * @return int
     */
    private function generateId()
    {
        return count($this->tasks) + 1;
    }

    private function findDueDateFor(Task $task)
    {
        $dueDatesForTask = array_filter(
            $this->taskDueDate,
            function (TaskDueDate $dueDate) use ($task) {
                return $dueDate->taskId() == $task->id();
            }
        );
        if (count($dueDatesForTask) == 0) {
            return null;
        }

        $lastDueDate = array_pop($dueDatesForTask);

        return $lastDueDate->dueDate();
    }
}
