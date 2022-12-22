<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $username = ['Jean', 'Francois', 'Lucas', 'Alex', 'Louis', 'Jerome'];

        for ($u = 0; $u < 6; $u++){
            $user = new User();
            $user->setUsername($username[$u]);
            
            $password = $this->hasher->hashPassword($user, 'pass_1234');

            $user->setPassword($password);
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
