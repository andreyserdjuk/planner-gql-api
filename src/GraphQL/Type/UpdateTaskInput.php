<?php

namespace App\GraphQL\Type;

use App\Entity\TaskPriority;
use App\Entity\TaskStatus;
use Overblog\GraphQLBundle\Annotation as GQL;

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
    public ?TaskPriority $taskPriority;

    /**
     * @GQL\Field(type="TaskStatus")
     */
    public ?TaskStatus $taskStatus;
}
