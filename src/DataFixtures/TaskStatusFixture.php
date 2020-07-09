<?php

namespace App\DataFixtures;

use App\Entity\TaskStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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
