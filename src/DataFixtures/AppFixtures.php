<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    private UserPasswordHasherInterface $passwordHasher;
    public const CATEGORIES = [
        'Animation',
        'Horreur',
        'Action',
        'Romantique',

    ];
    public function load(ObjectManager $manager)
    {

        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('contributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'contributorpassword'
        );

        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();


        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();

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

        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
         * L'objet $faker que tu récupère est l'outil qui va te permettre
         * de te générer toutes les données que tu souhaites
         */

        for($i = 0; $i < 50; $i++) {
            $season = new Season();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
            $season->setNumber($faker->numberBetween(1, 10));
            $season->setYear($faker->year());
            $season->setDescription($faker->paragraphs(3, true));
            $season->setPoster('2');

            $season->setProgram($this->getReference('program_' . $faker->numberBetween(0, 5)));

            $manager->persist($season);
        }

        $manager->flush();

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
        $episode->setDuration(15);
        $this->addReference('episode_1', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $episode->setDuration(8.30);
        $this->addReference('episode_2', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $episode->setDuration(60.00);
        $this->addReference('episode_3', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $episode->setDuration(12.58);
        $this->addReference('episode_4', $episode);
        $manager->persist($episode);

        $episode = new Episode();
        $episode->setTitle($faker->firstname());
        $episode->setNumber($faker->numberBetween(1, 10));
        $episode->setDuration(4.12);
        $this->addReference('episode_5', $episode);
        $manager->persist($episode);


        $manager->flush();

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


}