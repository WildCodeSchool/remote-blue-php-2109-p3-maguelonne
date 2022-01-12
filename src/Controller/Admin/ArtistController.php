<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArtistType;

/**
 * @Route("/artist", name="artist_")
 */

class ArtistController extends AbstractController
{
    /**
     * création du formulaire d'ajout d'un artiste
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $artist = new Artist();

        //TODO: processing form

        $form = $this->createForm(ArtistType::class, $artist);

        return $this->renderForm('admin/artist/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/artist/index.html.twig');
    }
}
