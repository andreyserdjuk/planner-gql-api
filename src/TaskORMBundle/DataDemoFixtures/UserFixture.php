<?php

namespace Planner\TaskORMBundle\DataDemoFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Planner\TaskORMBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $om)
    {
        $user = new User();

        $user
            ->setEmail('demo@demo')
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    'demo'
                )
            )
        ;

        $om->persist($user);
        $om->flush();
    }
}
