<?php

namespace App\Tests\Functional\Api;

use App\Entity\Task;
use DateTime;

trait AssertTaskPropertiesTrait
{
    protected function assertTaskProperties(array $task): void
    {
        /* @var BaseTestCase $self */
        $self = $this;

        $keys = [
            'id',
            'title',
            'dateStart',
            'dateEnd',
            'taskPriority',
            'taskStatus',
        ];

        foreach ($keys as $key) {
            $self->assertArrayHasKey($key, $task);
        }

        /** @var Task $dbTask */
        $dbTask = $self->getContainer()->get('doctrine')->getRepository(Task::class)->find($task['id']);
        $self->assertEquals($task['title'], $dbTask->getTitle());
        $self->assertEquals($task['dateStart'], $dbTask->getDateStart()->format(DateTime::ISO8601));
        $self->assertEquals($task['dateEnd'], $dbTask->getDateEnd()->format(DateTime::ISO8601));
        if (isset($task['createdAt'])) {
            $self->assertEquals($task['createdAt'], $dbTask->getCreatedAt()->format(DateTime::ISO8601));
        }
        if (isset($task['updatedAt'])) {
            $self->assertEquals($task['updatedAt'], $dbTask->getUpdatedAt()->format(DateTime::ISO8601));
        }
        $self->assertEquals($task['taskPriority'], $dbTask->getTaskPriority()->getName());
        $self->assertEquals($task['taskStatus'], $dbTask->getTaskStatus()->getName());
    }
}
