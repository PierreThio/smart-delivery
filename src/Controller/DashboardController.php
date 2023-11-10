<?php

namespace App\Controller;

use App\Entity\RelayCenter;
use App\Entity\User;
use App\Form\RelayCenterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        // if(!$this->security->getUser()){
        //     return $this->redirectToRoute('app_login');
        // }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/dashboard/add/relay-center', name: 'app_dashboard_add_relay_center')]
    public function addRelayCenter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $relayCenter = new RelayCenter;

        $form = $this->createForm(RelayCenterType::class, $relayCenter);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($relayCenter);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/relay_center/add.html.twig', [
            'controller_name' => 'DashboardController',
            'relayCenterForm' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/user/{user}', name: 'app_dashboard_user')]
    public function userInformation(User $user): Response
    {

        return $this->render('dashboard/user/index.html.twig', [
            'controller_name' => 'DashboardController',
            'user' => $user,
        ]);
    }
}
