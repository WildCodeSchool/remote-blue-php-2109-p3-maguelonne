<?php

namespace App\Controller\Admin;

use App\Entity\Content;
use App\Form\ContentType;
use App\Entity\ContentTranslation;
use App\Repository\ContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/content", name="content_")
 */
class ContentController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ContentRepository $contentRepository): Response
    {
        return $this->render('admin/content/index.html.twig', [
            'contents' => $contentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($content);
            $entityManager->flush();

            return $this->redirectToRoute('admin_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/content/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Content $content, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/content/edit.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    /**
     * @param string $locale
     * @param content $content
     * @return Response
     * @Route("/{id}/add-translation/{locale}", name="add_translation")
     */
    public function addTranslation(
        string $locale,
        Content $content
    ): Response {
        $translation = new ContentTranslation();
        $translation->setTitle($content->getTitle());
        $translation->setLocale($locale);
        $translation->setSlug($this->slug($locale, $content->getTitle()));
        $content->addTranslation($translation);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_content_edit', ['id' => $content->getId(), 'locale' => $locale]);
    }

    /**
     * @Route("/{id}/delete-translation/{locale}", name="delete_translation", methods={"POST"})
     */
    public function deleteTranslation(
        Request $request,
        Content $content,
        string $locale,
        ContentranslationRepository $transRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $content->getId(), $request->request->get('_token'))) {
            $translation = $transRepository->findOneBy([
                'locale' => $locale,
                'translatable' => $content
            ]);
            if ($translation) {
                $content->removeTranslation($translation);
                $this->entityManager->flush();
            }
        }

        return $this->redirectToRoute('admin_content_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Content $content, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $content->getId(), $request->request->get('_token'))) {
            $entityManager->remove($content);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_content_index', [], Response::HTTP_SEE_OTHER);
    }
}
