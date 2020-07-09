<?php

namespace App\GraphQL\Mutation;

use App\Entity\Task;
use App\Entity\TaskStatus;
use App\GraphQL\Type\CreateTaskInput;
use App\GraphQL\Type\UpdateTaskInput;
use Doctrine\Persistence\ObjectManager;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Overblog\GraphQLBundle\Error\UserError;

class TaskMutation implements MutationInterface, AliasedInterface
{
    protected ObjectManager $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function createTask(CreateTaskInput $input)
    {
        $task = new Task();
        $task->setTitle($input->title);
        $task->setDateStart($input->dateStart);
        $task->setDateEnd($input->dateEnd);
        $task->setTaskPriority($input->taskPriority);

        $scheduled = $this->om->find(TaskStatus::class, TaskStatus::SCHEDULED);
        $task->setTaskStatus($scheduled);

        $this->om->persist($task);
        $this->om->flush();

        return $task->getId();
    }

    public function updateTask(UpdateTaskInput $input)
    {
        $task = $this->om->find(Task::class, $input->id);
        if (!$task) {
            throw new UserError('Task not found.');
        }

        if ($input->dateStart) {
            $task->setDateStart($input->dateStart);
        }

        if ($input->dateEnd) {
            $task->setDateEnd($input->dateEnd);
        }

        if ($input->taskPriority) {
            $task->setTaskPriority($input->taskPriority);
        }

        if ($input->title) {
            $task->setTitle($input->title);
        }

        if ($input->taskStatus) {
            $task->setTaskStatus($input->taskStatus);
        }

        $this->om->flush();

        return $task->getId();
    }

    public function deleteTask($id)
    {
        $task = $this->om->find(Task::class, $id);

        if (!$task) {
            throw new UserError('Task not found.');
        }

        $this->om->remove($task);
        $this->om->flush();

        return true;
    }

    public static function getAliases(): array
    {
        return [
            'createTask' => 'create_task',
            'updateTask' => 'update_task',
            'deleteTask' => 'delete_task',
        ];
    }
}
