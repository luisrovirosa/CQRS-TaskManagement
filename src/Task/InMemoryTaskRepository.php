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

    public function findTasksAssignedTo($userName)
    {
        return array();
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
        /** @var TaskDueDate $lastDueDate */
        $lastDueDate = $this->findLatestObjectRelatedWithTask($task, $this->dueDates);

        return $lastDueDate ? $lastDueDate->dueDate() : null;
    }

    private function findCompletedOn(Task $task)
    {
        /** @var TaskCompleted $lastCompletedOn */
        $lastCompletedOn = $this->findLatestObjectRelatedWithTask($task, $this->completedOn);

        return $lastCompletedOn ? $lastCompletedOn->completedOn() : null;
    }

    /**
     * @param Task $task
     * @param $input
     * @return array
     */
    private function findLatestObjectRelatedWithTask(Task $task, $input)
    {
        $relatedObjects = array_filter(
            $input,
            function (TaskId $taskId) use ($task) {
                return $taskId->taskId() == $task->id();
            }
        );
        if (count($relatedObjects) == 0) {
            return null;
        }

        return array_pop($relatedObjects);
    }
}
