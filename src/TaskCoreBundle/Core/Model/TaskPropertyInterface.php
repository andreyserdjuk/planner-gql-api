<?php

namespace Planner\TaskCoreBundle\Core\Model;

use Planner\TaskORMBundle\Entity\TaskProperty;

/**
 * Task can have multiple properties such as section: description, acceptance criteria, repository branch etc.
 * As the logic of every property processing can differ, it can be provided by module supplies the property.
 */
interface TaskPropertyInterface
{
    public function getId();

    public function getType(): string;

    public function getTask(): TaskInterface;

    public function getContent(): string;

    public function setType(string $type): self;

    public function setTask(TaskInterface $task): self;

    public function setContent(string $content): TaskProperty;
}
