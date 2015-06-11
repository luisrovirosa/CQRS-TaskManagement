<?php

namespace CQRS\Task;

interface QueryTaskRepository
{

    /**
     * @return TaskDTO[]
     */
    public function findAll();

    /**
     * @param $userName
     * @return TaskDTO[]
     */
    public function findTasksAssignedTo($userName);
}
