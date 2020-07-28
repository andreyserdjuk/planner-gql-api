<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * @GQL\Enum(values={
 *    @GQL\EnumValue(name="EQUALS"),
 *    @GQL\EnumValue(name="IN"),
 *    @GQL\EnumValue(name="GREATER_THAN_OR_EQUAL"),
 *    @GQL\EnumValue(name="LESS_THAN_OR_EQUAL"),
 *    @GQL\EnumValue(name="BETWEEN", description="must pass an array with [gte, lte] values. Example: query(filter: {name: SIZE, type:RANGE, value: [10, 50]})"),
 * })
 * @GQL\Description("The list of task entry fields available for usage as filter option.")
 */
class FilterOptionEnum
{
    const EQUALS = 'eq';
    const IN = 'in';
    const BETWEEN = 'between';
    const GREATER_THAN_OR_EQUAL = 'gte';
    const LESS_THAN_OR_EQUAL = 'lte';

    public $value;
}
