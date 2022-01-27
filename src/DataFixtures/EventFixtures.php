<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public const EVENT_NB = 30;


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::EVENT_NB; $i++) {
            $event = new Event();
            $faker = Factory::create('fr_FR');
            $event->setTitle($faker->word());
            $event->setText($faker->realText());
            $event->setPoster($faker->imageUrl(300, 300, 'event'));
            $event->setAlt($faker->word);
            $event->setDate($faker->dateTimeBetween('-3 years', 'now'));
            $event->setCategory($this->getReference('event_category_0'));
            $event->setSlug($faker->text(15));
            $event->setVideo($faker->imageUrl());
            $manager->persist($event);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventCategoryFixtures::class,
        ];
    }
}
