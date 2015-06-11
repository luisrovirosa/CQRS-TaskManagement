<?php

namespace CQRS\Test\Task;

use CQRS\Task\CommandTaskRepository;
use CQRS\Task\InMemoryTaskRepository;
use CQRS\Task\QueryTaskRepository;
use CQRS\Task\TaskDTO;

class InMemoryTaskRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const TASK_NAME = 'My task name';
    const TASK_ID = 1;
    const USER = 'Luis Rovirosa';

    /** @var QueryTaskRepository */
    protected $queryRepository;

    /** @var CommandTaskRepository */
    protected $commandTaskRepository;

    protected function setUp()
    {
        parent::setUp();
        $repository = new InMemoryTaskRepository();
        $this->queryRepository = $repository;
        $this->commandTaskRepository = $repository;
        $this->queryRepository->createTask(self::TASK_NAME);
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

    /** @test */
    public function the_first_task_has_id_1()
    {
        $this->assertEquals(1, $this->findLastTask()->id());
    }

    /** @test */
    public function the_task_from_repository_is_a_dto()
    {
        $this->assertInstanceOf('CQRS\Task\TaskDTO', $this->findLastTask());
    }

    /** @test */
    public function schedule_task_set_the_due_date()
    {
        $dueDate = $this->schedule('yesterday');
        $this->assertEquals($dueDate, $this->findLastTask()->dueDate());
    }

    /** @test */
    public function schedule_task_twice_the_due_date_is_the_latest()
    {
        $this->schedule('yesterday');
        $today = $this->schedule('now');
        $this->assertEquals($today, $this->findLastTask()->dueDate());
    }

    /** @test */
    public function complete_task_is_null_when_the_task_is_not_completed()
    {
        $this->assertNull($this->findLastTask()->completedOn());
    }

    /** @test */
    public function complete_task_sets_the_current_date()
    {
        $this->commandTaskRepository->complete(self::TASK_ID);
        $this->assertNotNull($this->findLastTask()->completedOn());
    }

    /** @test */
    public function retrieve_my_tasks_gets_no_task_when_there_is_no_task_assigned_to_me()
    {
        $myTasks = $this->queryRepository->findTasksAssignedTo(self::USER);
        $this->assertCount(0, $myTasks);
    }

    /** @test */
    public function retrieve_the_task_assigned_to_me_after_assign_the_task_to_me()
    {
        $this->commandTaskRepository->assignTo(self::TASK_ID, self::USER);
        $myTasks = $this->queryRepository->findTasksAssignedTo(self::USER);
        $this->assertCount(1, $myTasks);
        $this->assertContains(self::USER, $myTasks[0]->assignedTo());
    }

    // -------------- Helpers -----------------

    /**
     * @return TaskDTO[]
     */
    private function findAllTasks()
    {
        return $this->queryRepository->findAll();
    }

    /**
     * @return TaskDTO
     */
    private function findLastTask()
    {
        $allTasks = $this->findAllTasks();
        $lastTaskPosition = count($allTasks) - 1;

        return $allTasks[$lastTaskPosition];
    }

    /**
     * @param $time
     * @return \DateTime
     */
    private function schedule($time)
    {
        $today = new \DateTime($time);
        $this->commandTaskRepository->schedule(self::TASK_ID, $today);

        return $today;
    }
}
