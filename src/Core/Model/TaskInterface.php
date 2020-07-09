<?php

namespace App\Core\Model;

interface TaskInterface
{
    /**
     * @return int|string
     */
    public function getId();

    public function getTitle(): string;

    public function getTaskPriority(): TaskPriorityInterface;

    /**
     * @return TaskPropertyInterface[]
     */
    public function getTaskProperties(): iterable;

    public function getDateStart(): ?\DateTime;

    public function getDateEnd(): ?\DateTime;

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt();

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt();
}
