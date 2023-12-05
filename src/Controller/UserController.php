<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    #[Route('/profil', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
