<?php

namespace App\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * @GQL\Enum()
 */
class SortOrderEnum
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    public $value;
}
