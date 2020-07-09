<?php

namespace App\GraphQL\Resolver;

use App\Core\Repository\TaskPriorityRepositoryInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class TaskPriorityResolver implements ResolverInterface, AliasedInterface
{
    protected TaskPriorityRepositoryInterface $repository;

    public function __construct(TaskPriorityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskPriorities()
    {
        return $this->repository->findAll();
    }

    public static function getAliases(): array
    {
        return [
            'findTaskPriorities' => 'find_task_priorities',
        ];
    }
}
