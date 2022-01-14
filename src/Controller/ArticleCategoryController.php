<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use App\Form\ArticleCategoryType;
use App\Repository\ArticleCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articleCategory", name="articleCategory_")
 */
class ArticleCategoryController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ArticleCategoryRepository $articleCatRepo): Response
    {
        return $this->render('articleCategory/index.html.twig', [
            'articleCategories' => $articleCatRepo->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(ArticleCategory $articleCategory): Response
    {
        return $this->render('articleCategory/show.html.twig', [
            'articleCategory' => $articleCategory,
        ]);
    }
}
