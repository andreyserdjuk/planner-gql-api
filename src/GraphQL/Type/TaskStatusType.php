<?php

namespace App\GraphQL\Type;

use App\Entity\TaskPriority;
use App\Entity\TaskStatus;
use Doctrine\Persistence\ObjectManager;
use GraphQL\Type\Definition\ScalarType;
use Overblog\GraphQLBundle\Annotation as GQL;
use Overblog\GraphQLBundle\Validator\Exception\ArgumentsValidationException;

class TaskStatusType extends ScalarType
{
    protected ObjectManager $om;

    public function __construct(ObjectManager $om)
    {
        parent::__construct();
        $this->om = $om;
    }

    /**
     * @param TaskStatus $value
     */
    public function serialize($value): string
    {
        return $value->getName();
    }

    public function parseValue($value)
    {
        return $this->om->getRepository(TaskStatus::class)->find($value);
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return $this->om->getRepository(TaskStatus::class)->find($valueNode->value);
    }
}
