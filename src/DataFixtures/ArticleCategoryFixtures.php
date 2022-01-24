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
        $this->addReference('articleCategory', $articleCategory);
        $manager->persist($articleCategory);

        $manager->flush();
    }
}
