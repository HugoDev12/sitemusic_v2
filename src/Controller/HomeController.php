<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    // route admin

    #[Route('/creators', name: 'app_creators')]
    public function creators(): Response
    {
        return $this->render('home/theCreators.html.twig');
    }
    
    #[Route('/privacyPolicy', name: 'app_privacyPolicy')]
    public function privacyPolicy(): Response
    {
        return $this->render('home/privacyPolicy.html.twig');
    }

}
