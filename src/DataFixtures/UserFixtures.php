<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // creation of a faker new object
        $faker = Factory::create('fr_FR');

        // creation of a new user
        for ($i = 0; $i < 5; $i++) {
            $candidat = new User();
            $candidat->setEmail($faker->email());
            $candidat->setPassword($faker->password());
            $candidat->setFirstname($faker->firstName());
            $candidat->setLastname($faker->lastName());
            $manager->persist($candidat);
            $this->addReference('user_' . $i, $candidat);
        }
        $manager->flush();
    }
}