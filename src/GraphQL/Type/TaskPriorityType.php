<?php

namespace App\GraphQL\Type;

use App\Entity\TaskPriority;
use Doctrine\Persistence\ObjectManager;
use GraphQL\Type\Definition\ScalarType;
use Overblog\GraphQLBundle\Annotation as GQL;
use Overblog\GraphQLBundle\Validator\Exception\ArgumentsValidationException;

class TaskPriorityType extends ScalarType
{
    protected ObjectManager $om;

    public function __construct(ObjectManager $om)
    {
        parent::__construct();
        $this->om = $om;
    }

    /**
     * @param TaskPriority $value
     */
    public function serialize($value): string
    {
        return $value->getName();
    }

    public function parseValue($value)
    {
        return $this->om->getRepository(TaskPriority::class)->find($value);
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return $this->om->getRepository(TaskPriority::class)->find($valueNode->value);
    }
}
