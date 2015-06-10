<?php

namespace CQRS\Test\Task;

use CQRS\Task\InMemoryTaskRepository;

class InMemoryTaskRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const TASK_NAME = 'My task name';

    /** @test */
    public function it_retrieves_a_task_after_create_task()
    {
        $repository = new InMemoryTaskRepository();
        $repository->createTask(self::TASK_NAME);
        $allTasks = $repository->findAll();
        $this->assertCount(1, $allTasks);
    }

    /** @test */
    public function the_task_has_the_given_name()
    {
        $repository = new InMemoryTaskRepository();
        $repository->createTask(self::TASK_NAME);
        $allTasks = $repository->findAll();
        $task = $allTasks[0];
        $this->assertEquals(self::TASK_NAME, $task->name());
    }
}
