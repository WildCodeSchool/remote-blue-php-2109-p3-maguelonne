<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArtistFixtures extends Fixture
{
    public const ARTIST_NUMS = 6;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::ARTIST_NUMS; $i++) {
            $artist = new Artist();
            $artist->setName($faker->name());
            $artist->setNationality($faker->text(20));
            $artist->setRepository($faker->text(20));
            $artist->setPhoto('https://fakeimg.pl/350x200/?text=artist ' . $i);
            $artist->setAlt($faker->text());
            $artist->setBody($faker->realText());
            $artist->setSlug($faker->text());
            $manager->persist($artist);
        }
        $manager->flush();
    }
}
