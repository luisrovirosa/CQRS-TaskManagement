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

    /** @var TaskAssignedTo[] */
    private $assignedTo;

    function __construct()
    {
        $this->tasks = [];
        $this->dueDates = [];
        $this->completedOn = [];
        $this->assignedTo = [];
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
     * @param int $taskId
     */
    public function complete($taskId)
    {
        $this->completedOn[] = new TaskCompleted($taskId);
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
        $allTasks = $this->findAll();

        return array_filter(
            $allTasks,
            function (TaskDTO $taskDTO) use ($userName) {
                return in_array($userName, $taskDTO->assignedTo());
            }
        );
    }

    public function assignTo($taskId, $userName)
    {
        $this->assignedTo[] = new TaskAssignedTo($taskId, $userName);
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
        $assignedTo = $this->findAssignedTo($task);

        return new TaskDTO($task->id(), $task->name(), $dueDate, $completedOn, $assignedTo);
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
        $relatedObjects = $this->findAllObjectsRelatedWithTask($task, $input);
        if (count($relatedObjects) == 0) {
            return null;
        }

        return array_pop($relatedObjects);
    }

    private function findAssignedTo(Task $task)
    {
        $assignedTo = $this->findAllObjectsRelatedWithTask($task, $this->assignedTo);

        return array_map(
            function (TaskAssignedTo $assignedTo) {
                return $assignedTo->assignedTo();
            },
            $assignedTo
        );
    }

    /**
     * @param Task $task
     * @param $input
     * @return array
     */
    private function findAllObjectsRelatedWithTask(Task $task, $input)
    {
        return array_filter(
            $input,
            function (TaskId $taskId) use ($task) {
                return $taskId->taskId() == $task->id();
            }
        );
    }
}
