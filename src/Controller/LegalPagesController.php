<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/legal/pages", name="legal_pages_")
 */
class LegalPagesController extends AbstractController
{
    /**
     * @Route("/informations", name="informations")
     */
    public function legalInformations(ContentRepository $contentRepository): Response
    {
        return $this->render(
            'legal_pages/informations.html.twig',
            [
                'content' => $contentRepository->findOneBy([
                    'id' => 5,
                ])
            ]
        );
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacyPolicy(ContentRepository $contentRepository): Response
    {
        return $this->render(
            'legal_pages/privacy.html.twig',
            [
                'content' => $contentRepository->findOneBy([
                    'id' => 4,
                ])
            ]
        );
    }
}
