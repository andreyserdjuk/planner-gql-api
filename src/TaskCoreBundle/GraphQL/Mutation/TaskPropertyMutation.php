<?php

namespace Planner\TaskCoreBundle\GraphQL\Mutation;

use Doctrine\Persistence\ObjectManager;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Planner\TaskCoreBundle\Core\Model\TaskPropertyInterface;
use Planner\TaskCoreBundle\GraphQL\Type\CreateTaskPropertyInput;

class TaskPropertyMutation implements MutationInterface, AliasedInterface
{
    protected ObjectManager $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function createTaskProperty(CreateTaskPropertyInput $input)
    {
        $className = $this->om->getRepository(TaskPropertyInterface::class)->getClassName();
        /** @var TaskPropertyInterface $taskProperty */
        $taskProperty = new $className();
        $taskProperty->setContent($input->content);
        $taskProperty->setType($input->type);
        $taskProperty->setTask($input->task);

        $this->om->persist($taskProperty);
        $this->om->flush();

        return $taskProperty->getId();
    }

    public static function getAliases(): array
    {
        return [
            'createTaskProperty' => 'create_task_property',
        ];
    }
}