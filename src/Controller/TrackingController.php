<?php

namespace App\Controller;

use App\Entity\Package;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrackingController extends AbstractController
{
    #[Route('/tracking/{tracking_number}', name: 'app_tracking')]
    public function index(Package $package): Response
    {
        if($this->isGranted('ROLE_ADMIN')){
            $role = 'ADMIN';

            return $this->render('tracking/index.html.twig', [
                'trackingNumber' => $package->getTrackingNumber(),
                'role' => $role
            ]);
        }

        return $this->render('tracking/index.html.twig', [
            'trackingNumber' => $package->getTrackingNumber()
        ]);
    }
}
