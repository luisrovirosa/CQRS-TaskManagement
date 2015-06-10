<?php

namespace CQRS\Task;

interface TaskId
{
    /**
     * @return int
     */
    public function taskId();
}
