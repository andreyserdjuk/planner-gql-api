<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use GraphQL\Type\Definition\ScalarType;
use Planner\TaskCoreBundle\Core\Model\TaskInterface;
use Planner\TaskCoreBundle\Core\Repository\TaskRepositoryInterface;

/**
 * @see TaskInterface
 */
class TaskIdentityType extends ScalarType
{
    protected TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * @param TaskInterface $value
     */
    public function serialize($value): string
    {
        return $value->getId();
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
