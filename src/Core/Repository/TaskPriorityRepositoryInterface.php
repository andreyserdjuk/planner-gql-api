<?php

namespace App\Core\Repository;

use App\Core\Model\TaskPriorityInterface;

interface TaskPriorityRepositoryInterface
{
    /**
     * @param $id
     *
     * @return TaskPriorityInterface|null
     */
    public function find($id);
}
