<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;
use Planner\TaskCoreBundle\Core\Model\TaskPriorityInterface;
use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GQL\Input
 */
class CreateTaskInput
{
    /**
     * @GQL\Field(type="String!")
     * @Assert\NotBlank()
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

// todo do it later
//    /**
//     * @GQL\Field(type="")
//     */
//    private array $taskProperties;

    /**
     * @GQL\Field(type="TaskPriority!")
     * @Assert\NotBlank()
     */
    public ?TaskPriorityInterface $taskPriority;

    /**
     * @GQL\Field(type="TaskStatus!")
     * @Assert\NotBlank()
     */
    public TaskStatusInterface $taskStatus;
}
