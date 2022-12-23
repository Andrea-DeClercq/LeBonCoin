<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\User;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager,): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 12; $i++) {
            $annonce = new Annonce();
            $annonce->setTitle($faker->word());
            $annonce->setDescription($faker->sentences('3', true));
            $annonce->setPrice(mt_rand(10, 100));
            $annonce->setCategorie($this->getReference(Categorie::class.'_'.mt_rand(0,9)));
            $annonce->setAnnonceByUser($this->getReference(User::class.'_'.mt_rand(0,9)));

            $createdAt = $faker->dateTimeBetween('-6 months');
            
            $annonce->setCreatedAt($createdAt);

            $updateAtDays = (new DateTime())->diff($createdAt)->days;

            $annonce->setUpdatedAt($faker->dateTimeBetween('-' . $updateAtDays . ' days'));

            $manager->persist($annonce);
        }
        // A compléter pour générer les catégories et les users
        $manager->flush();
    }

    

    public static function getGroups(): array
    {
        return['group2'];
    }
}
