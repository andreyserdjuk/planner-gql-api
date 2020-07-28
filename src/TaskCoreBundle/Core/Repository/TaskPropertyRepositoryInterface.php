<?php

namespace Planner\TaskCoreBundle\Core\Repository;

use Planner\TaskCoreBundle\Core\Model\TaskInterface;

interface TaskPropertyRepositoryInterface
{
    /**
     * @param $id
     *
     * @return TaskInterface|null
     */
    public function find($id);
}
