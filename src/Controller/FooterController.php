<?php

namespace App\Controller;

use App\Entity\Content;
use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("/footer", name="footer")
     */
    public function footer(ContentRepository $contentRepository): Response
    {
        return $this->render('_footer.html.twig', [
            'content' => $contentRepository->findOneBy(
                [
                    'id' => 3
                ]
            )
        ]);
    }
}
