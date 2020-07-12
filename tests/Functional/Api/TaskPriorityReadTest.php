<?php

namespace App\Tests\Functional\Api;

class TaskPriorityReadTest extends BaseTestCase
{
    public function testGetPriorityList()
    {
        $gql = <<<'GQL'
            {
              task_priorities
            }
            GQL;
        $response = $this->execGraphQL($gql, []);
        $this->assertNotEmpty($response['data']['task_priorities']);
        $preloadedStatuses = [
            'high',
            'low',
            'normal',
        ];

        foreach ($response['data']['task_priorities'] as $taskStatus) {
            $this->assertContains($taskStatus, $preloadedStatuses);
        }
    }
}
