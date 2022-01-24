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
        $this->addReference('content_1', $content);
        $manager->persist($content);
        $content = new Content();
        $content->setTitle('Présentation de l\'association');
        $content->setBody($faker->realtext(500));
        $content->setSlug($content->getTitle());
        $this->addReference('content_2', $content);
        $manager->persist($content);

        $manager->flush();
    }
}
