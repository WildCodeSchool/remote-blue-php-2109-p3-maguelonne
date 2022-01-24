<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $artists = $this->getDoctrine()
            ->getRepository(Artist::class)
            ->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }
}
