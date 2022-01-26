<?php

namespace App\DataFixtures;

use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventCategoryFixtures extends Fixture
{
    public const CATEGORY_NUMBER = 4;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::CATEGORY_NUMBER; $i++) {
            $eventCategory = new EventCategory();
            $eventCategory->setName($faker->text(80));
            $eventCategory->setSlug($faker->text(80));
            $manager->persist($eventCategory);
            $this->addReference('event_category_' . $i, $eventCategory);
        }


        $manager->flush();
    }
}
