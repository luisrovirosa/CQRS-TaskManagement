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

    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

    public function id()
    {
        return $this->id;
    }
}
