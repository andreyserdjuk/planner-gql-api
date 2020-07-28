<?php

namespace Planner\TaskORMBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Planner\TaskORMBundle\Entity\TaskPriority;

class TaskPriorityFixture extends Fixture
{
    public function load(ObjectManager $om)
    {
        $priorities = [
            'low',
            'normal',
            'high',
        ];

        foreach ($priorities as $index => $priorityName) {
            $priority = new TaskPriority();
            $priority
                ->setName($priorityName)
                ->setLabel($priorityName)
                ->setOrder($index);

            $om->persist($priority);
        }

        $om->flush();
    }
}
