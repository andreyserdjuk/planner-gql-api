<?php

namespace Planner\TaskCoreBundle\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GQL\Input
 */
class UpdateTaskPropertyInput
{
    /**
     * @GQL\Field(type="ID!")
     */
    public $id;

    /**
     * @GQL\Field(type="String!")
     * @Assert\NotNull()
     */
    public string $content;
}
