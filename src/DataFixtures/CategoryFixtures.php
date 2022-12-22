<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public const CATEGORY_TITLE = '';

    public function load(ObjectManager $manager): void
    {
        $categoryTitle = ['Jardin', 'Cuisine', 'Menager', 'Informatique', 'Autres'];
        for ($c = 0; $c < 5; $c++) {
            $category = new Categorie();
            $category->setTitle($categoryTitle[$c]);
            $manager->persist($category);
            $this->addReference(Categorie::class. '_'. $c , $category);
        }
        
        $manager->flush();

    }

    public static function getGroups(): array
    {
        return['categorie'];
    }
}
