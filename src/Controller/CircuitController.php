<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CircuitController extends AbstractController
{
    #[Route('/circuitos', name: 'circuit')]
    public function index(): Response
    {
        return $this->render('circuit/index.html.twig', [
            'controller_name' => 'CircuitController',
        ]);
    }
}
