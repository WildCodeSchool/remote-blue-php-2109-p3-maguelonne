<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\DateTime;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $faker = Factory::create('fr_FR');

        $event->setTitle($faker->sentence());
        $event->setText($faker->realText());
        $event->setPoster('https://picsum.photos/300/300');
        $event->setAlt($faker->word);
        $event->setDate(new DateTime($faker->date('d-m-Y')));
        $event->setHour(new DateTime($faker->time()));
        $event->setCategory($this->getReference('event_category_0'));
        $event->setSlug($faker->text(15));


        $manager->persist($event);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventCategoryFixtures::class,
        ];
    }
}
