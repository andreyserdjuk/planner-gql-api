<?php

namespace Planner\TaskCoreBundle\Core\Repository;

use Planner\TaskCoreBundle\Entity\TaskStatus;

interface TaskStatusRepositoryInterface
{
    /**
     * @return TaskStatus[]
     */
    public function findAll();
}
