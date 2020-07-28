<?php

namespace Planner\TaskORMBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Planner\TaskORMBundle\Entity\TaskStatus;

class TaskStatusFixture extends Fixture
{
    public function load(ObjectManager $om)
    {
        foreach ([
                     TaskStatus::SCHEDULED,
                     TaskStatus::DONE,
                 ] as $index => $statusName) {
            $priority = new TaskStatus();
            $priority
                ->setName($statusName)
                ->setLabel($statusName);

            $om->persist($priority);
        }

        $om->flush();
    }
}
