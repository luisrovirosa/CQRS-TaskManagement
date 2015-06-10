<?php

namespace CQRS\Task;

class InMemoryTaskRepository implements TaskRepository
{
    /** @var Task[] */
    private $tasks;

    /** @var TaskDueDate[] */
    private $dueDates;

    /** @var TaskCompleted[] */
    private $completedOn;

    function __construct()
    {
        $this->tasks = [];
        $this->dueDates = [];
        $this->completedOn = [];
    }

    /**
     * @param string $name
     */
    public function createTask($name)
    {
        $this->tasks[] = new Task($this->generateId(), $name);
    }

    /**
     * @param int $id
     * @param \DateTime $dueDate
     */
    public function schedule($id, \DateTime $dueDate)
    {
        $this->dueDates[] = new TaskDueDate($id, $dueDate);
    }

    /**
     * @param int $id
     */
    public function complete($id)
    {
        $this->completedOn[] = new TaskCompleted($id);
    }

    /**
     * @return TaskDTO[]
     */
    public function findAll()
    {
        return array_map(
            function (Task $task) {
                return $this->createDTO($task);
            },
            $this->tasks
        );
    }


    // ------------------------ Helpers --------------
    /**
     * @param Task $task
     * @return TaskDTO
     */
    private function createDTO(Task $task)
    {
        $dueDate = $this->findDueDateFor($task);
        $completedOn = $this->findCompletedOn($task);

        return new TaskDTO($task->id(), $task->name(), $dueDate, $completedOn);
    }

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
            $this->dueDates,
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

    private function findCompletedOn(Task $task)
    {
        $dueDatesForTask = array_filter(
            $this->completedOn,
            function (TaskCompleted $dueDate) use ($task) {
                return $dueDate->taskId() == $task->id();
            }
        );
        if (count($dueDatesForTask) == 0) {
            return null;
        }

        $lastDueDate = array_pop($dueDatesForTask);

        return $lastDueDate->completedOn();
    }
}
