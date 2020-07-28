<?php

namespace Planner\TaskCoreBundle\Core\Model;

interface TaskPriorityInterface
{
    public function getName(): string;

    public function getLabel(): string;

    public function getOrder(): int;
}
