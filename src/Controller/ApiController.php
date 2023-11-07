<?php

namespace App\Controller;

use App\Repository\PackageRepository;
use App\Repository\RelayCenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Utils;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{

    private $security;

    public function __construct(Security $security){
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

    #[Route('/api/package', name: 'app_api_package')]
    public function getAllPackages(Request $request, PackageRepository $repository): Response
    {
        $var = $repository->findAll();
        $response = new Utils;
        $tab = ["locker","localisation"];
        return $response->GetJsonResponse($request, $var,$tab);
    }

    #[Route('/api/relay-center', name: 'app_api_relayCenter')]
    public function getAllRelayCenter(Request $request, RelayCenterRepository $repository): Response
    {
        $var = $repository->findAll();
        $response = new Utils;
        $tab = ["users"];
        return $response->GetJsonResponse($request, $var,$tab);
    }
}