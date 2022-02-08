<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\ArticleTranslation;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\ArticleCategoryRepository;
use App\Repository\ArticleTranslationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article_")
 */
class ArticleController extends AbstractTranslatorController
{
    private EntityManagerInterface $entityManager;

    /**
     * ArticleController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository, ArticleCategoryRepository $articleCatRepo): Response
    {
        return $this->render('admin/article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC']),
            'article_categories' => $articleCatRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(
        Request $request
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $locale = 'fr';
            $translation = new ArticleTranslation();
            $translation->setLocale($locale);
            $translation->setTitle($form->getData()->getTitle());
            $translation->setTitle($form->getData()->getTitle());
            $translation->setSummary($form->getData()->getSummary());
            $translation->setBody($form->getData()->getBody());
            $translation->setAlt($form->getData()->getAlt());
            $translation->setSlug($this->slug($locale, $form->getData()->getTitle()));
            $article->addTranslation($translation);
            $this->entityManager->persist($article);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Article $article
    ): Response {
        $locale = $request->query->get('locale');
        $article->setCurrentLocale($locale);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $translation = $article->translate($locale, false);
            $translation->setTitle($article->getTitle());
            $translation->setSummary($article->getSummary());
            $translation->setBody($article->getBody());
            $translation->setAlt($article->getAlt());
            $translation->setSlug($this->slug($locale, $article->getTitle()));
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @param string $locale
     * @param Article $article
     * @return Response
     * @Route("/{id}/add-translation/{locale}", name="add_translation")
     */
    public function addTranslation(
        string $locale,
        Article $article
    ): Response {
        $translation = new ArticleTranslation();
        $translation->setTitle($article->getTitle());
        $translation->setLocale($locale);
        $translation->setSlug($this->slug($locale, $article->getTitle()));
        $article->addTranslation($translation);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_article_edit', ['id' => $article->getId(), 'locale' => $locale]);
    }

    /**
     * @Route("/{id}/delete-translation/{locale}", name="delete_translation", methods={"POST"})
     */
    public function deleteTranslation(
        Request $request,
        Article $article,
        string $locale,
        ArticleTranslationRepository $transRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $translation = $transRepository->findOneBy([
                'locale' => $locale,
                'translatable' => $article
            ]);
            if ($translation) {
                $article->removeTranslation($translation);
                $this->entityManager->flush();
            }
        }

        return $this->redirectToRoute('admin_article_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
