<?php

namespace App\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * @GQL\Input
 */
class TaskSortingInput
{
    /**
     * @GQL\Field(
     *     type="TaskSortNameEnum!"
     * )
     */
    public TaskSortNameEnum $by;

    /**
     * @GQL\Field(
     *     type="SortOrderEnum!"
     * )
     */
    public SortOrderEnum $dir;
}
