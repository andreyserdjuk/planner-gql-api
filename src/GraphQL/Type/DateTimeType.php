<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ScalarType;
use Overblog\GraphQLBundle\Annotation as GQL;

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
