<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageAtHomeType;
use App\Form\PackageType;
use App\Repository\PackageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHLAK\StrGen;

class PackageController extends AbstractController
{
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
            $generator = new StrGen\Generator();
            do {
                $trackingNumber = $generator->length(10)->charset([StrGen\CharSet::UPPER_ALPHA, StrGen\CharSet::NUMERIC])->generate();
            } while ($repository->findBy(['tracking_number' => $trackingNumber]) != null);
            $package->setTrackingNumber($trackingNumber);
            $package->setUser($this->getUser());
            $entityManager->persist($package);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('package/sendToRelayCenter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/colis/home', name: 'app_package_home')]
    public function sendToRHome(Request $request, EntityManagerInterface $entityManager, PackageRepository $repository): Response
    {
        $package = new Package;
        $form = $this->createForm(PackageAtHomeType::class, $package);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $generator = new StrGen\Generator();
            do {
                $trackingNumber = $generator->length(10)->charset([StrGen\CharSet::UPPER_ALPHA, StrGen\CharSet::NUMERIC])->generate();
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