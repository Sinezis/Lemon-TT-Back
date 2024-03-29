<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $event = new Event();
            $event->setTitle($faker->words(3, true));
            $event->setDescription($faker->sentence(1));
            $event->setLocation($faker->city());
            $event->setCreatedBy($this->getReference('user_' . rand(0, 4)));
            $event->setCreatedAt(new \DateTimeImmutable());
            $event->setStartDate($faker->dateTimeInInterval('+1 week', '+3 days'));
            $event->setEndDate($faker->dateTimeInInterval('+4 days', '+30 days'));
            $manager->persist($event);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}