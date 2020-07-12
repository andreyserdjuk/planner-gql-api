<?php

namespace App\Tests\Functional\Api;

use App\Entity\Task;
use DateTime;

class TaskCRUDTest extends BaseTestCase
{
    public function testCreateTask()
    {
        $gql = <<<'GQL'
            mutation createTask($input: CreateTaskInput!) {
              createTask(input: $input)	
            }
            GQL;

        $title = 'Test task';
        $dateStart = '2020-07-07T00:00:00+0000';
        $dateEnd = '2020-07-07T23:59:59+0000';
        $taskPriority = 'normal';
        $input = [
            'input' => [
                'title' => $title,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'taskPriority' => $taskPriority,
            ],
        ];

        $response = $this->execGraphQL($gql, $input);
        $this->assertNotEmpty($response['data']['createTask']);
        $taskId = $response['data']['createTask'];
        /** @var Task $task */
        $task = $this->getContainer()->get('doctrine')->getRepository(Task::class)->find($taskId);
        $this->assertEquals($taskId, $task->getId());
        $this->assertEquals($title, $task->getTitle());
        $this->assertEquals($dateStart, $task->getDateStart()->format(DateTime::ISO8601));
        $this->assertEquals($dateEnd, $task->getDateEnd()->format(DateTime::ISO8601));
        $this->assertEquals($taskPriority, $task->getTaskPriority()->getName());
    }

    public function testGetTaskById()
    {
        $gql = <<<'GQL'
            query task($input: ID!){
              task(id: $input) {
                id
                title
                dateStart
                dateEnd
                createdAt
                updatedAt
                taskPriority
                taskStatus
              }
            }
            GQL;

        $response = $this->execGraphQL($gql, ['input' => 1]);
        $this->assertTaskProperties($response['data']['task']);
        $responseTask = $response['data']['task'];
        /** @var Task $task */
        $task = $this->getContainer()->get('doctrine')->getRepository(Task::class)->find(1);
        $this->assertEquals(1, $task->getId());
        $this->assertEquals($responseTask['title'], $task->getTitle());
        $this->assertEquals($responseTask['dateStart'], $task->getDateStart()->format(DateTime::ISO8601));
        $this->assertEquals($responseTask['dateEnd'], $task->getDateEnd()->format(DateTime::ISO8601));
        $this->assertEquals($responseTask['taskPriority'], $task->getTaskPriority()->getName());
        $this->assertEquals($responseTask['taskStatus'], $task->getTaskStatus()->getName());
    }

    public function testUpdateTask()
    {
        $gql = <<<'GQL'
            mutation updateTask($input: UpdateTaskInput!) {
              updateTask(input: $input)	
            }
            GQL;
        $newTitle = 'Test task updated';
        $newDateStart = '2020-01-01T00:00:00+0000';
        $newDateEnd = '2021-07-07T23:59:59+0000';
        $newPriority = 'high';
        $newStatus = 'done';
        $input = [
            'input' => [
                'id' => 1,
                'title' => $newTitle,
                'dateStart' => $newDateStart,
                'dateEnd' => $newDateEnd,
                'taskPriority' => $newPriority,
                'taskStatus' => $newStatus,
            ],
        ];
        $this->execGraphQL($gql, $input);
        /** @var Task $task */
        $task = $this->getContainer()->get('doctrine')->getRepository(Task::class)->find(1);
        $this->assertNotNull($task);
        $this->assertEquals(1, $task->getId());
        $this->assertEquals($newTitle, $task->getTitle());
        $this->assertEquals($newDateStart, $task->getDateStart()->format(DateTime::ISO8601));
        $this->assertEquals($newDateEnd, $task->getDateEnd()->format(DateTime::ISO8601));
        $this->assertEquals($newPriority, $task->getTaskPriority()->getName());
        $this->assertEquals($newStatus, $task->getTaskStatus()->getName());
    }

    public function testDeleteTask()
    {
        $gql = <<<'GQL'
            mutation deleteTask($input: ID!) {
              deleteTask(input: $input)
            }
            GQL;
        $response = $this->execGraphQL($gql, ['input' => 1]);
        $this->assertTrue($response['data']['deleteTask']);
    }

    public function testGetDefaultList()
    {
        $gql = <<<'GQL'
            {
              tasks {
                id
                title
                dateStart
                dateEnd
                createdAt
                updatedAt
                taskPriority
                taskStatus
              }
            }
            GQL;

        $response = $this->execGraphQL($gql, []);
        $tasks = $response['data']['tasks'];
        $this->assertCount(100, $tasks);

        foreach ($tasks as $task) {
            $this->assertTaskProperties($task);
        }
    }

    protected function assertTaskProperties(array $task): void
    {
        $keys = [
            'id',
            'title',
            'dateStart',
            'dateEnd',
            'createdAt',
            'updatedAt',
            'taskPriority',
            'taskStatus',
        ];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $task);
        }

        $this->assertNotEmpty($task['id']);
        $this->assertTrue((bool) stristr($task['title'], 'task number'));
        $this->assertContains($task['taskStatus'], ['scheduled', 'done']);
        $this->assertContains($task['taskPriority'], ['low', 'normal', 'high']);

        foreach (['createdAt', 'updatedAt', 'dateStart', 'dateEnd'] as $key) {
            $date = DateTime::createFromFormat(DateTime::ISO8601, $task[$key]);
            $this->assertInstanceOf(DateTime::class, $date);
        }
    }
}
