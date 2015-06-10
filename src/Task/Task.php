<?php

namespace CQRS\Task;

class Task
{
    /** @var int */
    private $id;

    /** @var  string */
    private $name;

    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    public function id()
    {
        return $this->id;
    }
}
