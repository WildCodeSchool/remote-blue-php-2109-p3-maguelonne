<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public const ARTICLENUMS = 30;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::ARTICLENUMS; $i++) {
            $article = new Article();
            $article->setTitle($faker->text(45));
            $article->setSummary($faker->realtext(150));
            $article->setBody($faker->realtext(500));
            $article->setPoster('https://fakeimg.pl/350x200/?text=article ' . $i);
            $article->setCreatedAt($faker->dateTimeBetween('-4  weeks', 'now'));
            $article->setDuration($faker->randomNumber(2));
            $article->setAlt($faker->text(25));
            $article->setCategory($this->getReference('articleCategory_' . rand(1, 3)));
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleCategoryFixtures::class,
        ];
    }
}
