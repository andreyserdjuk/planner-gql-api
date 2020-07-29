<?php

namespace Planner\TaskCoreBundle\Core\Model;

interface TaskPropertyInterface
{
    public function getId();

    public function getType(): string;

    public function getTask(): TaskInterface;

    public function getContent(): string;
}