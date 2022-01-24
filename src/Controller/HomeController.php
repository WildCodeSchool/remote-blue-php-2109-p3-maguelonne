<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Content;
use App\Repository\ContentRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ContentRepository $contentRepository): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'content' => $contentRepository->findOneBy(
                    [
                        'id' => 1
                    ]
                )
            ]
        );
    }
}
