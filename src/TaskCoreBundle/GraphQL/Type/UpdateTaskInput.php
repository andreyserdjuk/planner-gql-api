<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;
use Planner\TaskCoreBundle\Core\Model\TaskPriorityInterface;
use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;

/**
 * @GQL\Input
 */
class UpdateTaskInput
{
    /**
     * @GQL\Field(type="ID!")
     */
    public $id;

    /**
     * @GQL\Field(type="String")
     */
    public ?string $title;

    /**
     * @GQL\Field(type="DateTime")
     */
    public ?\DateTime $dateStart;

    /**
     * @GQL\Field(type="DateTime")
     */
    public ?\DateTime $dateEnd;

    /**
     * @GQL\Field(type="TaskPriority")
     */
    public ?TaskPriorityInterface $taskPriority;

    /**
     * @GQL\Field(type="TaskStatus")
     */
    public ?TaskStatusInterface $taskStatus;
}
