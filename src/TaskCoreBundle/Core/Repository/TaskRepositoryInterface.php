<?php

namespace Planner\TaskCoreBundle\Core\Repository;

use Planner\TaskCoreBundle\Core\Model\TaskInterface;

interface TaskRepositoryInterface
{
    /**
     * @param $id
     *
     * @return TaskInterface|null
     */
    public function find($id);

    /**
     * @return iterable
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    public function getPagedByCriteria(
        array $filters,
        array $sortings,
        int $limit,
        int $offset
    ): array;
}
