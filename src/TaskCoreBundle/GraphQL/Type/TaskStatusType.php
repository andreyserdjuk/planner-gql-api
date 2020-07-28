<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;
use Planner\TaskCoreBundle\Core\Repository\TaskStatusRepositoryInterface;
use GraphQL\Type\Definition\ScalarType;

class TaskStatusType extends ScalarType
{
    protected TaskStatusRepositoryInterface $repository;

    public function __construct(TaskStatusRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * @param TaskStatusInterface $value
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
