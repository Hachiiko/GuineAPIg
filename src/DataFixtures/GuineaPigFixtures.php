<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\GuineaPig;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GuineaPigFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $admin = $this->getReference('admin');

        $guineaPig = (new GuineaPig())
            ->setOwner($admin)
            ->setName('Dida')
            ->setAge(2)
            ->setBreed('Sheltie')
            ->setColor('Tricolor');

        $manager->persist($guineaPig);

        $guineaPig = (new GuineaPig())
            ->setOwner($admin)
            ->setName('Kapi')
            ->setAge(2)
            ->setBreed('Belted')
            ->setColor('Black');

        $manager->persist($guineaPig);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}