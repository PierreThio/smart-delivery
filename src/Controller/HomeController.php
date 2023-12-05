<?php

namespace App\Controller;

use App\Form\TrackingNumberType;
use App\Repository\PackageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $security;

    public function __construct(Security $security,){
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager, PackageRepository $repository): Response
    {
        $user = $this->security->getUser();

        $form = $this->createForm(TrackingNumberType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $trackingNumber = $form->getData()['tracking_number'];
            if($repository->findBy(['tracking_number' => $trackingNumber]) == null){
                if($user){
                    return $this->render('home/index.html.twig', [
                        'form' => $form,
                        'user' => $user,
                        'error' => 'Le numéro de suivi n\'existe pas'
                    ]);
                } else{
                    return $this->render('home/index.html.twig', [
                        'form' => $form,
                        'error' => 'Le numéro de suivi n\'existe pas'
                    ]);
                }
            }else{
                return $this->redirectToRoute('app_tracking', ['tracking_number' => $form->getData()['tracking_number']]);
            }
        }

        if($user){
            return $this->render('home/index.html.twig', [
                'form' => $form,
                'user' => $user
            ]);
        } else{
            return $this->render('home/index.html.twig', [
                'form' => $form
            ]);
        }
    }
}
