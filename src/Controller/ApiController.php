<?php

namespace App\Controller;

use App\Entity\Locker;
use App\Entity\Package;
use App\Entity\RelayCenter;
use App\Repository\PackageRepository;
use App\Repository\RelayCenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Utils;
use Doctrine\Common\Collections\ArrayCollection;
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
    public function userIsLoggedIn(Request $request): Response
    {
        $var = $this->security->getUser();
        $response = new Utils;
        $tab = ["lockers","packages", "relayCenter", "notifications"];
        return $response->GetJsonResponse($request, $var,$tab);
    }

    #[Route('/api/package', name: 'app_api_package')]
    public function getAllPackages(Request $request, PackageRepository $repository): Response
    {
        $var = $repository->findAll();
        $response = new Utils;
        $tab = ["localisation"];
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

    #[Route('/api/relay-center/available-lockers/{id}', name: 'app_api_availableLockers')]
    public function getAvailableLockers(RelayCenter $relayCenter, Request $request): Response
    {
        $availableLockers = new ArrayCollection();
        foreach($relayCenter->getLockers() as $locker){
            if($locker->getStatus() == "Available"){
                $availableLockers->add($locker);
            }
        }
        $var = $availableLockers;
        $response = new Utils;
        $tab = ["users", "packages"];
        return $response->GetJsonResponse($request, $var, $tab);
    }

    #[Route('/api/locker/{id}/available-volume', name: 'app_api_availableLockerVolume')]
    public function getAvailableLockerVolume(Locker $locker, Request $request): Response
    {
        $var = $locker->getAvailableVolume();
        $response = new Utils;
        return $response->GetJsonResponse($request, $var);
    }

    #[Route('/api/tracking/{tracking_number}', name: 'app_api_trackedPackage')]
    public function getTrackedPackage(Package $package, Request $request): Response
    {
        $var = $package;
        $response = new Utils;
        return $response->GetJsonResponse($request, $var);
    }
}