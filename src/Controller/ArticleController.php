<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\ArticleCategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article_")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET","POST"})
     */
    public function index(ArticleRepository $articleRepository, ArticleCategoryRepository $articleCatRepo): Response
    {
        $form = $this->createFormBuilder()
        ->add('categories', EntityType::class, [
            'class' => ArticleCategory::class,
            'choice_label' => function (?ArticleCategory $articleCategory) {
                return $articleCategory();
            },
            'multiple' => true,
            'expanded' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'submit'])
        ->getForm();
        return $this->renderForm('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'articleCategories' => $articleCatRepo->findAll(),
            'formCategoryFilter' => $form,
        ]);
    }

    /**
     * Getting an article by id
     * @Route("/{id}", name="show", methods={"GET"})
     * @return Response
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
