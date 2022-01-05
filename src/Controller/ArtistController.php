<?php

namespace App\Controller;

use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/artist", name="artist_")
 */

class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $artist = $this->getDoctrine()
        ->getRepository(Artist::class)
        ->findAll();

        return $this->render('artist/index.html.twig', [
            'artist' => $artist,
        ]);
    }
}
