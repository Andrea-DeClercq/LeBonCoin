<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public const USER_REFERENCE = '';

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;   
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        // $username = ['Jean', 'Francois', 'Lucas', 'Alex', 'Louis', 'Jerome'];

        for ($u = 0; $u < 6; $u++){
            $user = new User();
            $username = $faker->firstName();

            $user->setUsername($username);
            
            $password = $this->hasher->hashPassword($user, 'pass_1234');

            $user->setPassword($password);

            $createdAt = $faker->dateTimeBetween('-6 months');

            $user->setCreatedAt($createdAt);

            $updateAtDays = (new DateTime())->diff($createdAt)->days;

            $user->setUpdatedAt($faker->dateTimeBetween('-' . $updateAtDays . ' days'));

            $manager->persist($user);
            $this->addReference(User::class.'_'.$u, $user);
        }

        $manager->flush();
        // $this->addReference(self::USER_REFERENCE, $user);
    }

    public static function getGroups(): array
    {
        return['group1'];
    }
}
