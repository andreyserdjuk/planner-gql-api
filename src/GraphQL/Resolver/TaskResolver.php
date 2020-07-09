<?php

namespace App\GraphQL\Resolver;

use App\Core\Model\TaskInterface;
use App\Core\Repository\TaskRepositoryInterface;
use App\GraphQL\Type\TaskFilterInput;
use App\GraphQL\Type\TaskSortingInput;

class TaskResolver
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
        // todo criteria
        $filtering = array_map(fn(TaskFilterInput $filter) => [$filter->name->value, $filter->type->value, $filter->value], $filters);
        $sorting = array_map(fn(TaskSortingInput $sort) => [$sort->by->value, $sort->dir->value], $sortings);
        $offset = $page * $limit;

        return $this->repository->getPagedByCriteria($filtering, $sorting, $limit, $offset);
    }
}
