<?php

namespace Planner\Tests\Functional\Api;

use Doctrine\Persistence\ManagerRegistry;
use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;
use Planner\TaskCoreBundle\Core\Repository\TaskStatusRepositoryInterface;
use Planner\TaskORMBundle\Entity\TaskStatus;

class TaskStatusCRUDTest extends BaseTestCase
{
    public function testGetStatusList()
    {
        $gql = <<<'GQL'
            {
              task_statuses
            }
            GQL;
        $response = $this->execGraphQL($gql, []);
        $this->assertIsArray($response['data']['task_statuses']);
        $preloadedStatuses = [
            'done',
            'in-progress',
            'scheduled',
        ];

        foreach ($response['data']['task_statuses'] as $taskStatus) {
            $this->assertContains($taskStatus, $preloadedStatuses);
        }
    }

    public function testCreateTaskStatus()
    {
        $gql = <<<'GQL'
            mutation createTaskStatus($input: CreateTaskStatusInput!) {
              createTaskStatus(input: $input)	
            }
            GQL;

        $managerRegistry = $this->getContainer()->get('doctrine');

        $name = 'task_status_new';
        $label = 'task status label new';

        $input = [
            'input' => [
                'name' => $name,
                'label' => $label,
            ],
        ];

        $response = $this->execGraphQL($gql, $input);
        $taskStatusId = $response['data']['createTaskStatus'];

        /** @var TaskStatusInterface $taskStatus */
        $taskStatus = $managerRegistry->getRepository(TaskStatusInterface::class)->find($taskStatusId);
        $this->assertEquals($name, $taskStatus->getName());
        $this->assertEquals($label, $taskStatus->getLabel());
    }

    public function testUpdateTaskStatus()
    {
        $gql = <<<'GQL'
            mutation updateTaskStatus($input: UpdateTaskStatusInput!) {
              updateTaskStatus(input: $input)
            }
            GQL;

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getContainer()->get('doctrine');

        /** @var TaskStatusInterface $taskStatus */
        $taskStatus = $managerRegistry->getRepository(TaskStatusInterface::class)->find(TaskStatus::SCHEDULED);

        $label = 'updated scheduled';
        $input = [
            'input' => [
                'name' => $taskStatus->getName(),
                'label' => $label,
            ],
        ];
        $response = $this->execGraphQL($gql, $input);
        $this->assertTrue($response['data']['updateTaskStatus']);
        $managerRegistry->getManager()->refresh($taskStatus);

        $this->assertEquals($label, $taskStatus->getLabel());
    }

    public function testDeleteTaskStatus()
    {
        /** @var TaskStatusRepositoryInterface $repository */
        $repository = $this->getContainer()->get('doctrine')->getRepository(TaskStatusInterface::class);
        $this->assertNotNull($repository->find(TaskStatus::SCHEDULED));

        $gql = <<<'GQL'
            mutation deleteTaskStatus($input: ID!) {
              deleteTaskStatus(input: $input)
            }
            GQL;
        $response = $this->execGraphQL($gql, ['input' => TaskStatus::SCHEDULED]);
        $this->assertTrue($response['data']['deleteTaskStatus']);
        $this->assertNull($repository->find(TaskStatus::SCHEDULED));
    }
}
