<?php

namespace Planner\Tests\Functional\Api;

class TaskFilterTest extends BaseTestCase
{
    use AssertTaskPropertiesTrait;

    /**
     * @dataProvider statusDataProvider
     */
    public function testTaskStatusFilter($status, $taskCount)
    {
        $gql = <<<'GQL'
            {
              tasks(filter: [
                {
                  name: TASK_STATUS,
                  type: EQUALS,
                  value: "%s"
                }
              ],
                limit: 100,
                page: 0
              ) {
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

        $response = $this->execGraphQL(sprintf($gql, $status), []);
        $this->assertCount($taskCount, $response['data']['tasks']);
        foreach ($response['data']['tasks'] as $task) {
            $this->assertEquals($status, $task['taskStatus']);
            $this->assertTaskProperties($task);
        }
    }

    public function statusDataProvider()
    {
        return [
            ['scheduled', 20],
            ['done', 80],
        ];
    }
}
