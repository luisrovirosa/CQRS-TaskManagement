<?php

namespace CQRS\Test\Task;

use CQRS\Task\InMemoryTaskRepository;
use CQRS\Task\TaskRepository;

class InMemoryTaskRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const TASK_NAME = 'My task name';

    /** @var TaskRepository */
    protected $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = new InMemoryTaskRepository();
        $this->repository->createTask(self::TASK_NAME);
    }

    /** @test */
    public function it_retrieves_a_task_after_create_task()
    {
        $this->assertCount(1, $this->findAllTasks());
    }

    /** @test */
    public function the_task_has_the_given_name()
    {
        $this->assertEquals(self::TASK_NAME, $this->findLastTask()->name());
    }

    /**
     * @return mixed
     */
    private function findAllTasks()
    {
        return $this->repository->findAll();
    }

    /**
     * @return mixed
     */
    private function findLastTask()
    {
        $allTasks = $this->findAllTasks();
        $lastTaskPosition = count($allTasks) - 1;

        return $allTasks[$lastTaskPosition];
    }
}
