<?php

namespace Planner\TaskCoreBundle\Core\Repository;

use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;

interface TaskStatusRepositoryInterface
{
    /**
     * @return TaskStatusInterface[]
     */
    public function findAll();
}
