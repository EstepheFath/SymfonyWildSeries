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
        $program->setName("C'est super ca");
        $program->setSynopsis('Bravo Nilse');
        $program->setCategory($this->getReference('category_Action'));
        $program->setPoster('2');
        $this->addReference('program_1', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setName('LALALALALALALLALLA');
        $program->setSynopsis('LA LAL LAL ALLA LAL LALL LALLA LAL LALAL LALL AL');
        $program->setCategory($this->getReference('category_Horreur'));
        $program->setPoster('2');
        $this->addReference('program_2', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setName('OuiOui');
        $program->setSynopsis('Le taxi');
        $program->setCategory($this->getReference('category_Animation'));
        $program->setPoster('2');
        $this->addReference('program_3', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setName('Walking Dead');
        $program->setSynopsis('Des joueurs de zombies envahissent la terre');
        $program->setCategory($this->getReference('category_Horreur'));
        $program->setPoster('2');
        $this->addReference('program_4', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setName("Plus d'inspi");
        $program->setSynopsis('Plus rien du tout');
        $program->setCategory($this->getReference('category_Horreur'));
        $program->setPoster('2');
        $this->addReference('program_5', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setName('Symfony');
        $program->setSynopsis('Le meilleur');
        $program->setCategory($this->getReference('category_Horreur'));
        $program->setPoster('2');
        $this->addReference('program_0', $program);
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

