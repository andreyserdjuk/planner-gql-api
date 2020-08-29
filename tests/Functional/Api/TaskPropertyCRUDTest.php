<?php

namespace Planner\Tests\Functional\Api;

use Doctrine\Persistence\ManagerRegistry;
use Planner\TaskCoreBundle\Core\Model\TaskInterface;
use Planner\TaskCoreBundle\Core\Model\TaskPropertyInterface;

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

        /** @var TaskInterface $task */
        $task = $managerRegistry->getRepository(TaskInterface::class)->findOneBy([]);
        $content = 'Here is task description.';
        $type = 'section_description';

        $input = [
            'input' => [
                'task' => $task->getId(),
                'content' => $content,
                'type' => $type,
            ],
        ];

        $response = $this->execGraphQL($gql, $input);
        $this->assertNotEmpty($response['data']['createTaskProperty']);
        $taskPropertyId = $response['data']['createTaskProperty'];

        /** @var TaskPropertyInterface $taskProperty */
        $taskProperty = $managerRegistry->getRepository(TaskPropertyInterface::class)->find($taskPropertyId);
        $this->assertEquals($content, $taskProperty->getContent());
        $this->assertEquals($type, $taskProperty->getType());
        $this->assertEquals($task, $taskProperty->getTask());
    }

    public function testUpdateTaskProperty()
    {
        $gql = <<<'GQL'
            mutation updateTaskProperty($input: UpdateTaskPropertyInput!) {
              updateTaskProperty(input: $input)
            }
            GQL;

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getContainer()->get('doctrine');

        /** @var TaskPropertyInterface $taskProperty */
        $taskProperty = $managerRegistry->getRepository(TaskPropertyInterface::class)->findOneBy([
            'type' => 'description',
        ]);

        $content = 'updated description';
        $input = [
            'input' => [
                'id' => $taskProperty->getId(),
                'content' => $content,
            ],
        ];
        $this->execGraphQL($gql, $input);
        $managerRegistry->getManager()->refresh($taskProperty);

        $this->assertEquals($content, $taskProperty->getContent());
    }
}
