<?php

namespace Planner\Tests\Functional\Api;

use DateTime;
use Planner\TaskORMBundle\Entity\Task;
use Planner\TaskORMBundle\Entity\TaskStatus;

class TaskCRUDTest extends BaseTestCase
{
    use AssertTaskPropertiesTrait;

    public function testLogin()
    {
        $this->markTestSkipped('todo auth');
        static::$client->request(
            'POST',
            '/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'security' => [
                    'credentials' => [
                        'login' => 'admin@planner',
                        'password' => 'demo',
                    ],
                ],
            ])
        );

        $rawResponse = self::$client->getResponse()->getContent();
        $response = json_decode($rawResponse, true);
    }

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
                'taskStatus' => TaskStatus::SCHEDULED,
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
