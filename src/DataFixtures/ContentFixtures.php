<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ContentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugger = new AsciiSlugger();

        $content = new Content();
        $content->setTitle('Présentation du site');
        $content->setSlug($content->getTitle());
        $content->setBody($faker->realtext(500));
        $content->setPoster('https://zupimages.net/up/22/04/b2d6.jpg');
        $content->setAlt($faker->text(25));
        $manager->persist($content);

        $content = new Content();
        $content->setTitle('Présentation de l\'association');
        $content->setBody($faker->realtext(500));
        $content->setPoster('https://zupimages.net/up/22/04/ivos.jpeg');
        $content->setAlt($faker->text(25));
        $content->setSlug($content->getTitle());
        $manager->persist($content);

        $content = new Content();
        $content->setTitle('Footer');
        $content->setBody($faker->realtext(200));
        $manager->persist($content);

        $content = new Content();
        $title = 'Politique de confidentialité';
        $content->setTitle($title);
        $content->setBody($faker->realtext(500));
        $content->setSlug($slugger->slug(strtolower($title)));
        $manager->persist($content);

        $content = new Content();
        $title = 'Mentions légales';
        $content->setTitle($title);
        $content->setBody($faker->realtext(500));
        $content->setSlug($content->getTitle());
        $content->setSlug($slugger->slug(strtolower($title)));
        $manager->persist($content);

        $manager->flush();
    }
}
