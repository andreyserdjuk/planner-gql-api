<?php

namespace Planner\TaskCoreBundle\Core\Model;

interface TaskStatusInterface
{
    public function getName(): string;

    public function setName(string $name): self;

    public function getLabel(): string;

    public function setLabel(string $label): TaskStatusInterface;
}
