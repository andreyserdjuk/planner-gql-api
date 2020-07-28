<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * @GQL\Input
 */
class TaskFilterInput
{
    /**
     * @GQL\Field(type="TaskFilterOptionNameEnum!")
     *
     * @var TaskFilterOptionNameEnum
     */
    public $name;

    /**
     * @GQL\Field(type="FilterOptionEnum!")
     *
     * @var FilterOptionEnum
     */
    public $type;

    /**
     * @GQL\Field(type="[String]!")
     *
     * @var string[]
     */
    public $value;
}
