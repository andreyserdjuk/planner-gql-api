<?php

namespace App\GraphQL\Resolver;

use App\Core\Repository\TaskStatusRepositoryInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class TaskStatusResolver implements ResolverInterface, AliasedInterface
{
    protected TaskStatusRepositoryInterface $repository;

    public function __construct(TaskStatusRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findTaskStatuses()
    {
        return $this->repository->findAll();
    }

    public static function getAliases(): array
    {
        return [
            'findTaskStatuses' => 'find_task_statuses',
        ];
    }
}
