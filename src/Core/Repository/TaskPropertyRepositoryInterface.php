<?php

namespace App\Core\Repository;

use App\Core\Model\TaskInterface;

interface TaskPropertyRepositoryInterface
{
    /**
     * @param $id
     *
     * @return TaskInterface|null
     */
    public function find($id);
}
