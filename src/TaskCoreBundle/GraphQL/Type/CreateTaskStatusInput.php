<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GQL\Input
 */
class CreateTaskStatusInput
{
    /**
     * @GQL\Field(type="String!")
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @GQL\Field(type="String!")
     * @Assert\NotBlank()
     */
    public string $label;
}
