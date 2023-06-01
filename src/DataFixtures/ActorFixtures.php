<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        for($i = 0; $i < 10; $i++) {
            //src/DataFixtures/EpisodeFixtures.php
            $actor = new Actor();
            $actor->setName($faker->firstname());
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 5)));
            $this->setReference('actor_', $actor);

            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}