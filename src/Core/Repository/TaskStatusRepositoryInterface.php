<?php

namespace App\Core\Repository;

use App\Entity\TaskStatus;

interface TaskStatusRepositoryInterface
{
    /**
     * @return TaskStatus[]
     */
    public function findAll();
}
