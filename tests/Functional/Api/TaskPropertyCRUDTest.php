<?php

namespace Planner\Tests\Functional\Api;

use Planner\TaskCoreBundle\Core\Model\TaskPropertyInterface;
use Planner\TaskORMBundle\Entity\Task;
use Planner\TaskORMBundle\Entity\TaskProperty;

class TaskPropertyCRUDTest extends BaseTestCase
{
    public function testCreateTaskProperty()
    {
        $gql = <<<'GQL'
            mutation createTaskProperty($input: CreateTaskPropertyInput!) {
              createTaskProperty(input: $input)	
            }
            GQL;

        $managerRegistry = $this->getContainer()->get('doctrine');

        /** @var Task $task */
        $task = $managerRegistry->getRepository(Task::class)->findOneBy([]);
        $content = 'Here is task description.';
        $type = 'section_description';

        $input = [
            'input' => [
                'task' => ['id' => $task->getId()],
                'content' => $content,
                'type' => $type,
            ],
        ];

        $response = $this->execGraphQL($gql, $input);
        $this->assertNotEmpty($response['data']['createTaskProperty']);
        $taskPropertyId = $response['data']['createTaskProperty'];
        /** @var TaskPropertyInterface $taskProperty */
        $taskProperty = $managerRegistry->getRepository(TaskProperty::class)->find($taskPropertyId);
        $this->assertEquals($content, $taskProperty->getContent());
        $this->assertEquals($type, $taskProperty->getType());
        $this->assertEquals($task, $taskProperty->getTask());
    }
}
