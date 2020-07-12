<?php

namespace App\Tests\Functional\Api;

use App\Entity\Task;
use DateTime;

class TaskCRUDTest extends BaseTestCase
{
    use AssertTaskProperties;

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
        $this->assertTaskProperties($input['input']);
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
}
