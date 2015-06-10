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

    /** @var  \DateTime */
    private $dueDate;

    function __construct($id, $name, $dueDate = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->dueDate = $dueDate;
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
}
