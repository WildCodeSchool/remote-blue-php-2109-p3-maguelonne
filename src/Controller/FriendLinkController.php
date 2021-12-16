<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FriendLinkController extends AbstractController
{
    /**
     * @Route("/friendlink", name="friend_link")
     */
    public function index(): Response
    {
        return $this->render('friend_link/index.html.twig', [
            'controller_name' => 'FriendLinkController',
        ]);
    }
}
