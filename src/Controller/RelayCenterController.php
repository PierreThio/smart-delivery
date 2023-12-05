<?php

namespace App\Controller;

use App\Entity\Locker;
use App\Entity\RelayCenter;
use App\Form\RelayCenterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelayCenterController extends AbstractController
{

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    #[Route('/points-relais', name: 'app_relay_center')]
    public function index(): Response
    {
        return $this->render('relay_center/index.html.twig', [
            'controller_name' => 'RelayCenterController',
        ]);
    }

    #[Route('/points-relais/locker/{locker}/update', name: 'app_relay_center_locker_update')]
    public function lockerUpdate(Locker $locker, EntityManagerInterface $entityManager)
    {
            $user = $this->security->getUser();
            $locker->setStatus('Unavailable');
            $locker->setUser($this->getUser());
            $user->addLocker($locker);

            $entityManager->flush();
    }
    #[Route('/points-relais/{relayCenter}/delete', name: 'app_relay_center_delete')]
    public function deleteRelayCenter(RelayCenter $relayCenter, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($relayCenter);
        $entityManager->flush();
    }
    #[Route('/points-relais/{relayCenter}/update', name: 'app_relay_center_update')]
    public function updateRelayCenter(RelayCenter $relayCenter, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(RelayCenterType::class, $relayCenter);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($relayCenter);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/relay_center/update.html.twig', [
            'controller_name' => 'DashboardController',
            'relayCenterForm' => $form->createView(),
        ]);
    }
}
