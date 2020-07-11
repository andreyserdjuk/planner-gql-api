<?php

namespace App\Tests\Functional\Api;

use DateTime;

class TaskTest extends BaseTestCase
{
    public function testGetDefaultList()
    {
        $gql = '{
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
        }';

        $response = static::execGraphQL(null, $gql, []);
        $this->assertArrayHasKey('data', $response);
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
