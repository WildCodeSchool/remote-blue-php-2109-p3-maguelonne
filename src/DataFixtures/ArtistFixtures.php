<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArtistFixtures extends Fixture
{
    public const ARTIST_NUMS = 30;
    public const LOCALES = ['fr' => 'FR', 'en' => 'EN'];

    public function load(ObjectManager $manager): void
    {
        $fakerFactory = Factory::create();
        $slugger = new AsciiSlugger();
        $fakerFR = Factory::create('fr_FR');
        $fakerEN = Factory::create('en_EN');
        for ($i = 0; $i < self::ARTIST_NUMS; $i++) {
            $artist = new Artist();
            foreach (self::LOCALES as $key => $locale) {
                $faker = 'faker' . $locale;
                $artist->translate($key)->setRepository($$faker->realtext(20));
                $artist->translate($key)->setNationality($$faker->realtext(20));
                $artist->translate($key)->setBody($$faker->realText());
                $artist->translate($key)->setInstruments($$faker->text());
                $artist->translate($key)->setAlt($$faker->text());
            }
            $name = $fakerFactory->name();
            $artist->setName($name);
            $artist->setPhoto('https://fakeimg.pl/350x200/?text=artist ' . $i);
            $artist->setSlug($slugger->slug(strtolower($name)));
            $manager->persist($artist);
            $artist->mergeNewTranslations();
        }
        $manager->flush();
    }
}
