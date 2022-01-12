<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/artist", name="artist_")
 */

class ArtistController extends AbstractController
{
    /**
     * lister les artistes
     * @Route("/", name="index")
     */
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('admin/artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
        ]);
    }

    /**
     * création du formulaire d'ajout d'un artiste
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artist/new.html.twig', [
            'form' => $form,
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Artist $artist): Response
    {
        return $this->render('admin/artist/show.html.twig', [
            'artists' => $artist,
        ]);
    }

    /**
     * Edition d'un artiste
     * @Route("/{slug}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Artist $artist,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artist/edit.html.twig', [
            'artists' => $artist,
            'form' => $form
        ]);
    }

    /**
     * formulaire de suppression d'un artiste
     * @Route("/{slug}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/artist/index.html.twig', [], Response::HTTP_SEE_OTHER);
    }
}
