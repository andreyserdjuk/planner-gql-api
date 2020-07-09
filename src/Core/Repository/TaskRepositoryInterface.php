<?php

namespace App\Core\Repository;

use App\Core\Model\TaskInterface;

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

    // todo criteria parser to ORM/ODM API
    public function getPagedByCriteria(
        array $filters,
        array $sortings,
        int $limit,
        int $offset
    ): array;
}
