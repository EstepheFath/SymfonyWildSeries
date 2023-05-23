<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $program = new Program();
        $program->setName('Walking Link');
        $program->setSynopsis('Des joueurs de Zelda envahissent la terre');
        $program->setCategory($this->getReference('category_Horreur'));
        $program->setPoster('2');
        $manager->persist($program);
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            AppFixtures::class,
        ];
    }


}

