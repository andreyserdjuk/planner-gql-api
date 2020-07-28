<?php

namespace Planner\TaskCoreBundle\GraphQL\Resolver;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Planner\TaskCoreBundle\Core\Repository\TaskPropertyRepositoryInterface;

class TaskPropertyResolver implements ResolverInterface, AliasedInterface
{
    protected TaskPropertyRepositoryInterface $repository;

    public function __construct(TaskPropertyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskProperties()
    {
        return $this->repository->findAll();
    }

    public static function getAliases(): array
    {
        return [
            'findTaskProperties' => 'find_task_properties',
        ];
    }
}
