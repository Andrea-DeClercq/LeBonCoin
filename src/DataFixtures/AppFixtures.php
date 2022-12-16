<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 12; $i++) {
            $annonce = new Annonce();
            $annonce->setTitle('annonce '.$i);
            $annonce->setDescription('description '.$i);
            $annonce->setPrice(mt_rand(10, 100));
            $annonce->setCreatedAt(new DateTimeImmutable());
            $manager->persist($annonce);
        }
        // A compléter pour générer les catégories et les users
        $manager->flush();
    }
}
