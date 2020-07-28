<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Planner\TaskCoreBundle\Core\Model\TaskPriorityInterface;
use GraphQL\Type\Definition\ScalarType;
use Planner\TaskCoreBundle\Core\Repository\TaskPriorityRepositoryInterface;

class TaskPriorityType extends ScalarType
{
    protected TaskPriorityRepositoryInterface $repository;

    public function __construct(TaskPriorityRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * @param TaskPriorityInterface $value
     */
    public function serialize($value): string
    {
        return $value->getName();
    }

    public function parseValue($value)
    {
        return $this->repository->find($value);
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return $this->repository->find($valueNode->value);
    }
}
