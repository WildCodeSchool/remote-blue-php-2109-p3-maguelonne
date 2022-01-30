<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public const ARTICLENUMS = 5;
    public const LOCALES = ['fr' => 'FR', 'en' => 'EN', 'ru' => 'RU'];

    public function load(ObjectManager $manager): void
    {
        $fakerFactory = Factory::create();
        $fakerFR = Factory::create('fr_FR');
        $fakerEN = Factory::create('en_EN');
        $fakerRU = Factory::create('ru_RU');
        for ($i = 0; $i < self::ARTICLENUMS; $i++) {
            $article = new Article();

            foreach (self::LOCALES as $key => $locale) {
                $faker = 'faker' . $locale;
                $article->translate($key)->setTitle($$faker->realtext(45));
                $article->translate($key)->setSummary($$faker->realtext(150));
                $article->translate($key)->setBody($$faker->realtext(500));
                $article->translate($key)->setAlt($$faker->text(25));
                $article->translate($key)->setSlug($$faker->realtext(45));
            }

            $article->setPoster('https://fakeimg.pl/350x200/?text=article ' . $i);

            $article->setCreatedAt($fakerFactory->dateTimeBetween('-4  weeks', 'now'));
            $article->setDuration($fakerFactory->randomNumber(2));
            $article->setCategory($this->getReference('articleCategory_' . rand(1, 3)));
            $manager->persist($article);
            $article->mergeNewTranslations();
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
