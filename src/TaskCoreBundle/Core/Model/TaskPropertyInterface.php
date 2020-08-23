<?php

namespace Planner\TaskCoreBundle\Core\Model;

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
}
