<?php

namespace Planner\TaskCoreBundle\Core\Repository;

use Planner\TaskCoreBundle\Core\Model\TaskPriorityInterface;

interface TaskPriorityRepositoryInterface
{
    /**
     * @param $id
     *
     * @return TaskPriorityInterface|null
     */
    public function find($id);

    /**
     * @return TaskPriorityInterface[]
     */
    public function findAll();
}
