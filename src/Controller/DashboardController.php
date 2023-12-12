<?php

namespace App\Controller;

use App\Entity\Localisation;
use App\Entity\Notification;
use App\Entity\Package;
use App\Entity\RelayCenter;
use App\Entity\User;
use App\Form\LocalisationType;
use App\Form\RelayCenterType;
use App\Repository\NotificationContentRepository;
use App\Repository\NotificationReceptionModeRepository;
use App\Repository\NotificationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Test\Constraint\NotificationCount;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardController extends AbstractController
{

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_home');
        }

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

    #[Route('/dashboard/tracking/localisation/{tracking_number}', name: 'app_dashboard_tracking_localisation')]
    public function addLocalisation(Package $package, Request $request, EntityManagerInterface $entityManager, NotificationContentRepository $contentRepository, NotificationReceptionModeRepository $receptionModeRepository): Response
    {
        $localisation = new Localisation;

        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $localisation->setPackage($package);
            $localisation->setTimestamp(new DateTime());
            if($package->getLastLocalisation() !== null && $package->getLastLocalisation()->getStep()->getWording() != $localisation->getStep()->getWording()){
                $notification = new Notification;
                $notification->setUser($this->security->getUser());
                $notification->setTimestamp(new DateTime());
                $notification->setNotificationReceptionMode($receptionModeRepository->findOneBy(['reception_mode' => "website"]));
                $notification->setNotificationContent($contentRepository->findOneBy(['content' => "Votre colis à changé d'état"]));
                $notification->setChecked(false);
                $entityManager->persist($notification);
            }
            $entityManager->persist($localisation);
            $entityManager->flush();

            return $this->redirectToRoute('app_tracking', ['tracking_number' => $package->getTrackingNumber()]);
        }

        return $this->render('/dashboard/tracking/localisation.html.twig', [
            'trackingNumber' => $package->getTrackingNumber(),
            'form' => $form,
        ]);
    }
}
