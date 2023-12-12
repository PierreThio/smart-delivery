<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DefaultRelayCenterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

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

    #[Route('/profil/ajout/centre-par-defaut', name: 'app_user_add_relayCenter')]
    public function addDefaultRelayCenter(HttpFoundationRequest $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(DefaultRelayCenterType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $relayCenter = $form->getData()->getRelayCenter();
            $user->setRelayCenter($relayCenter);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/add/relayCenter.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profil/modification/centre-par-defaut', name: 'app_user_update_relayCenter')]
    public function updateDefaultRelayCenter(HttpFoundationRequest $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(DefaultRelayCenterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $relayCenter = $form->getData()->getRelayCenter();
            $user->setRelayCenter($relayCenter);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/add/relayCenter.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profil/commandes', name: 'app_user_order')]
    public function orders(): Response
    {
        $user = $this->security->getUser();
        return $this->render('user/orders.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profil/notification/{id}/check', name: 'app_user_notification_check')]
    public function checkNotification(Notification $notification, EntityManagerInterface $entityManager)
    {
        $notification->setChecked(true);
        $entityManager->flush();
    }
}