<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user
            ->setUsername('admin')
            ->setPassword($this->userPasswordHasher->hashPassword($user, '123'));

        $manager->persist($user);
        $manager->flush();

        $this->setReference('admin', $user);

        $user = new User();

        $user
            ->setUsername('guest')
            ->setPassword($this->userPasswordHasher->hashPassword($user, '123'));

        $manager->persist($user);
        $manager->flush();

        $this->setReference('guest', $user);
    }
}