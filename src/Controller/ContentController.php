<?php

namespace App\Controller;

use App\Entity\Content;
use App\Repository\ContentRepository;
use GrumPHP\Configuration\Model\AsciiConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/", name="page_")
 */
class ContentController extends AbstractController
{
    public function renderTwig(ContentRepository $contentRepository, int $id): Response
    {
        return $this->render('_footer.html.twig', [
            'content' => $contentRepository->find($id)
        ]);
    }

    /** 
     * @Route("/{slug}", name="show")
     */
    public function show(Content $content): Response
    {
        return $this->render(
            'content/show.html.twig',
            [
                'content' => $content
            ]
        );
    }
}
