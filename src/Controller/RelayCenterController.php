<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelayCenterController extends AbstractController
{
    #[Route('/points-relais', name: 'app_relay_center')]
    public function index(): Response
    {
        return $this->render('relay_center/index.html.twig', [
            'controller_name' => 'RelayCenterController',
        ]);
    }
}
