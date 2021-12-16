<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;

class ArticleFixtures extends Fixture
{
    private const ARTICLES = [
        'Coucou les loulous',
        'Coucou les loulous2',
        'Coucou les loulous3',
        'Coucou les loulous4',
        'Coucou les loulous5',
    ];
    private const SLUGS = [
        'Coucou les loulous',
        'Coucou les loulous2',
        'Coucou les loulous3',
        'Coucou les loulous4',
        'Coucou les loulous5',
    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::ARTICLES as $key => $articleName) {
            $article = new Article();
            $article->setTitle($articleName);
            foreach (self::SLUGS as $key => $slugName) {
                $article->setSlug($slugName);
            }
            $article->setBody('Ca m\énerve de tout tape jui trop triste');
            $article->setPoster('<img src="https://fakeimg.pl/350x200/ff0000/000">');
            $article->setDuration(10);
            $date = new DateTimeImmutable('2000-01-01');
            $article->setCreatedAt($date);
            $category = new ArticleCategory();
            $article->setCategory($this->getReference('category_0'));
            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleCategory::class,
        ];
    }
}
