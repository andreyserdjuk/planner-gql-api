<?php

namespace Planner\TaskCoreBundle\GraphQL\Mutation;

use Doctrine\Persistence\ObjectManager;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Overblog\GraphQLBundle\Error\UserError;
use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;
use Planner\TaskCoreBundle\GraphQL\Type\CreateTaskStatusInput;
use Planner\TaskCoreBundle\GraphQL\Type\UpdateTaskStatusInput;

class TaskStatusMutation implements MutationInterface, AliasedInterface
{
    protected ObjectManager $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function createTaskStatus(CreateTaskStatusInput $input)
    {
        $className = $this->om->getRepository(TaskStatusInterface::class)->getClassName();
        /** @var TaskStatusInterface $taskStatus */
        $taskStatus = new $className();
        $taskStatus->setName($input->name);
        $taskStatus->setLabel($input->label);

        $this->om->persist($taskStatus);
        $this->om->flush();

        return $taskStatus->getName();
    }

    public function updateTaskStatus(UpdateTaskStatusInput $input)
    {
        /** @var TaskStatusInterface $taskStatus */
        $taskStatus = $this->om->find(TaskStatusInterface::class, $input->name);
        if (!$taskStatus) {
            throw new UserError(sprintf('TaskStatus#%s not found.', $input->name));
        }
        $taskStatus->setLabel($input->label);
        $this->om->flush();

        return true;
    }

    public function deleteTaskStatus($id): bool
    {
        $taskStatus = $this->om->find(TaskStatusInterface::class, $id);

        if (!$taskStatus) {
            throw new UserError('TaskStatus not found.');
        }

        $this->om->remove($taskStatus);
        $this->om->flush();

        return true;
    }

    public static function getAliases(): array
    {
        return [
            'createTaskStatus' => 'create_task_status',
            'updateTaskStatus' => 'update_task_status',
            'deleteTaskStatus' => 'delete_task_status',
        ];
    }
}
