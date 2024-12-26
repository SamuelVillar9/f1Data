<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DriverController extends AbstractController
{
    #[Route('/pilotos', name: 'driver')]
    public function index(): Response
    {
        return $this->render('driver/index.html.twig', [
            'controller_name' => 'DriverController',
        ]);
    }
}
