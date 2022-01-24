<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class ContentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $content = new Content();
        $content->setTitle('Présentation du site');
        $content->setSlug($content->getTitle());
        $content->setBody($faker->realtext(500));
        $content->setPoster('https://zupimages.net/up/22/04/b2d6.jpg');
        $content->setAlt($faker->text(25));
        $this->addReference('content_1', $content);
        $manager->persist($content);
        $content = new Content();
        $content->setTitle('Présentation de l\'association');
        $content->setBody($faker->realtext(500));
        $content->setPoster('https://zupimages.net/up/22/04/ivos.jpeg');
        $content->setAlt($faker->text(25));
        $content->setSlug($content->getTitle());
        $this->addReference('content_2', $content);
        $manager->persist($content);
        $content = new Content();
        $content->setTitle('Footer');
        $content->setBody($faker->realtext(200));
        $content->setSlug($content->getTitle());
        $this->addReference('content_3', $content);
        $manager->persist($content);

        $manager->flush();
    }
}
