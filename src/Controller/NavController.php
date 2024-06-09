<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MessagesRepository;

class NavController extends AbstractController
{
    #[Route('/nav', name: 'app_nav')]
    public function getUserNotifications(MessagesRepository $messages): Response
    {

        $unReadMsg = $messages->getUnreadMessages($this->getUser());

        return $this->render('nav.html.twig', [
            'countUnreadMsg' => count($unReadMsg)
        ]);
    }
}
