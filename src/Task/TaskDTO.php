<?php

namespace CQRS\Task;

class TaskDTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /** @var  \DateTime|null */
    private $dueDate;

    /**
     * @var \DateTime|null
     */
    private $completedOn;

    /**
     * @var array
     */
    private $assignedTo;

    function __construct($id, $name, $dueDate = null, $completedOn = null, $assignedTo = array())
    {
        $this->id = $id;
        $this->name = $name;
        $this->dueDate = $dueDate;
        $this->completedOn = $completedOn;
        $this->assignedTo = $assignedTo;
    }

    public function name()
    {
        return $this->name;
    }

    public function id()
    {
        return $this->id;
    }

    public function dueDate()
    {
        return $this->dueDate;
    }

    public function completedOn()
    {
        return $this->completedOn;
    }

    /**
     * @return array
     */
    public function assignedTo()
    {
        return $this->assignedTo;
    }
}
