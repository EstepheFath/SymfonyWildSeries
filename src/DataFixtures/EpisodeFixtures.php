<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        /*for($i = 0; $i < 50; $i++) {
            //src/DataFixtures/EpisodeFixtures.php
            $episode = new Episode();
            $episode->setTitle($faker->firstname());
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynopsis($faker->paragraph(3, true));*/

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $this->addReference('episode_1', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $this->addReference('episode_2', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $this->addReference('episode_3', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $this->addReference('episode_4', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $this->addReference('episode_5', $episode);
        $manager->persist($episode);


        $manager->flush();

        }
    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
