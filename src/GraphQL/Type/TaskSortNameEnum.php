<?php

namespace App\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * @GQL\Enum(values={
 *      @GQL\EnumValue(name="CREATED_AT", description="Timestamp in ISO8601 format."),
 *      @GQL\EnumValue(name="TASK_PRIORITY", description="Task priority."),
 * })
 * @GQL\Description("The list of task entry fields available for usage as sort option.")
 */
class TaskSortNameEnum
{
    public const CREATED_AT = 'createdAt';
    public const TASK_PRIORITY = 'taskPriority';

    public $value;
}
