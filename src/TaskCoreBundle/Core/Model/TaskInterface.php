<?php

namespace Planner\TaskCoreBundle\Core\Model;

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

    public function setTitle(string $content): self;

    public function setDateStart(?\DateTime $dateStart): self;

    public function setDateEnd(?\DateTime $dateEnd): self;

    public function setTaskPriority(TaskPriorityInterface $taskPriority): self;

    public function setTaskStatus(TaskStatusInterface $taskStatus): self;
}
