<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageAtHomeType;
use App\Form\PackageType;
use App\Repository\PackageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PackageController extends AbstractController
{
    private $security;

    public function __construct(Security $security,){
        $this->security = $security;
    }

    #[Route('/colis', name: 'app_package')]
    public function index(): Response
    {
        return $this->render('package/index.html.twig');
    }

    #[Route('/colis/relayCenter', name: 'app_package_relaycenter')]
    public function sendToRelayCenter(Request $request, EntityManagerInterface $entityManager, PackageRepository $repository): Response
    {
        $package = new Package;
        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            do {
                $trackingNumber = $package->generateTrackingNumber();
            } while ($repository->findBy(['tracking_number' => $trackingNumber]) != null);
            if($package->getLocker()->enoughVolumeChecker($package)){
                $locker = $package->getLocker();
                $locker->addPackage($package);
                if($locker->getAvailableVolume() == 0){
                    $locker->setStatus("Available");
                }
                $package->setTrackingNumber($trackingNumber);
                $package->setUser($this->getUser());
                $entityManager->persist($package);
                $entityManager->flush();
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('package/sendToRelayCenter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/colis/home', name: 'app_package_home')]
    public function sendToRHome(Request $request, EntityManagerInterface $entityManager, PackageRepository $repository): Response
    {
        $user = $this->security->getUser();
        $package = new Package;
        $form = $this->createForm(PackageAtHomeType::class, $package);
        $form->handleRequest($request);
        if($form->get('destination')->getData() == false && $user->getRelayCenter() == null){
            return $this->render('package/home.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        if($form->isSubmitted() && $form->isValid()){
            if($form->get('destination')->getData() == false){
                $locker = $user->getRelayCenter()->getrecommendedLocker();
                if(!$locker){
                    return $this->render('package/home.html.twig', [
                        'form' => $form->createView(),
                        'error' => 'Votre centre relais par défaut n\'a pas de casier disponible',
                    ]);
                }
                if($locker->enoughVolumeChecker($package)){
                    $package->setLocker($locker);
                    $locker->addPackage($package);
                    if($locker->getAvailableVolume() == 0){
                        $locker->setStatus("Available");
                    }
                }
                else{
                    return $this->render('package/home.html.twig', [
                        'form' => $form->createView(),
                        'error' => 'Votre centre relais par défaut n\'a pas de casier pouvant accueillir votre colis',
                    ]);
                }
            }
            do {
                $trackingNumber = $package->generateTrackingNumber();
            } while ($repository->findBy(['tracking_number' => $trackingNumber]) != null);
            $package->setTrackingNumber($trackingNumber);
            $package->setUser($this->getUser());
            $entityManager->persist($package);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('package/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}