<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use GraphQL\Type\Definition\ScalarType;

class DateTimeType extends ScalarType
{
    public function serialize($value): string
    {
        return $value->format(\DateTime::ISO8601);
    }

    public function parseValue($value)
    {
        return new \DateTime($value);
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return new \DateTime($valueNode->value);
    }
}
