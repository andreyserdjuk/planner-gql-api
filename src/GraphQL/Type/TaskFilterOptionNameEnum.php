<?php

namespace App\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * @GQL\Enum(values={
 *      @GQL\EnumValue(name="CREATED_AT", description="Timestamp in ISO8601 format."),
 *      @GQL\EnumValue(name="DATE_START", description="Timestamp in ISO8601 format."),
 *      @GQL\EnumValue(name="DATE_END", description="Timestamp in ISO8601 format."),
 *      @GQL\EnumValue(name="TASK_STATUS", description="Task status: scheduled, done."),
 * })
 * @GQL\Description("The list of task entry fields available for usage as filter option.")
 */
class TaskFilterOptionNameEnum
{
    public const CREATED_AT = 'createdAt';
    public const DATE_START = 'dateStart';
    public const DATE_END = 'dateEnd';
    public const TASK_STATUS = 'taskStatus';

    public $value;
}
