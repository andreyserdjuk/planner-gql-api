<?php

namespace Planner\TaskCoreBundle\GraphQL\Resolver;

use Planner\TaskCoreBundle\Core\Model\TaskInterface;
use Planner\TaskCoreBundle\Core\Repository\TaskRepositoryInterface;
use Planner\TaskCoreBundle\GraphQL\Type\TaskFilterInput;
use Planner\TaskCoreBundle\GraphQL\Type\TaskSortingInput;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class TaskResolver implements ResolverInterface, AliasedInterface
{
    protected TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int|string $id
     */
    public function findTask($id): ?TaskInterface
    {
        return $this->repository->find($id);
    }

    /**
     * @param TaskFilterInput[] $filters
     * @param TaskSortingInput[] $sortings
     * @return TaskInterface[]
     */
    public function findTasks(array $filters, array $sortings, int $limit, int $page): array
    {
        $filtering = array_map(fn(TaskFilterInput $filter) => [$filter->name->value, $filter->type->value, $filter->value], $filters);
        $sorting = array_map(fn(TaskSortingInput $sort) => [$sort->by->value, $sort->dir->value], $sortings);
        $offset = $page * $limit;

        return $this->repository->getPagedByCriteria($filtering, $sorting, $limit, $offset);
    }

    public static function getAliases(): array
    {
        return [
            'findTask' => 'find_task',
            'findTasks' => 'find_tasks',
        ];
    }
}
