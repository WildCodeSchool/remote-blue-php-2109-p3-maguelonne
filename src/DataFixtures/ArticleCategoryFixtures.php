<?php

namespace App\DataFixtures;

use App\Entity\ArticleCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $articleCategory = new ArticleCategory();
        $articleCategory->setName('Opéra');
        $this->addReference('articleCategory_1', $articleCategory);
        $manager->persist($articleCategory);
        $articleCategory = new ArticleCategory();
        $articleCategory->setName('Ballet');
        $this->addReference('articleCategory_2', $articleCategory);
        $manager->persist($articleCategory);
        $articleCategory = new ArticleCategory();
        $articleCategory->setName('Symphonies');
        $this->addReference('articleCategory_3', $articleCategory);
        $manager->persist($articleCategory);

        $manager->flush();
    }
}
