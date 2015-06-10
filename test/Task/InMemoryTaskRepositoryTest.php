<?php

namespace CQRS\Test\Task;

use CQRS\Task\InMemoryTaskRepository;

class InMemoryTaskRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_retrieves_a_task_after_create_task()
    {
        $repository = new InMemoryTaskRepository();
        $repository->createTask('My task name');
        $this->assertCount(1, $repository->findAll());
    }
}
