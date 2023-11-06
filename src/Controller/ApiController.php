<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    private $security;

    public function __construct(Security $security,){
        $this->security = $security;
    }

    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/api/userIsLoggedIn', name: 'app_api_user_is_logged_in')]
    public function userIsLoggedIn(): Response
    {
        $user = $this->security->getUser();

        return $this->json($user);
    }
}
