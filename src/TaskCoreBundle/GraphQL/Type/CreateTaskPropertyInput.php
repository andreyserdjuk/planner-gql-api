<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;
use Planner\TaskCoreBundle\Core\Model\TaskInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GQL\Input
 */
class CreateTaskPropertyInput
{
    /**
     * @GQL\Field(type="String!")
     * @Assert\NotBlank()
     */
    public string $type;

    /**
     * @GQL\Field(type="String!")
     * @Assert\NotBlank()
     */
    public string $content;

    /**
     * @GQL\Field(type="TaskIdentity!")
     * @Assert\NotBlank()
     */
    public TaskInterface $task;
}
