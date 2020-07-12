<?php

namespace App\Tests\Functional\Api;

class TaskStatusReadTest extends BaseTestCase
{
    public function testGetStatusList()
    {
        $gql = <<<'GQL'
            {
              task_statuses
            }
            GQL;
        $response = $this->execGraphQL($gql, []);
        $this->assertNotEmpty($response['data']['task_statuses']);
        $preloadedStatuses = [
            'done',
            'in-progress',
            'scheduled',
        ];

        foreach ($response['data']['task_statuses'] as $taskStatus) {
            $this->assertContains($taskStatus, $preloadedStatuses);
        }
    }
}
