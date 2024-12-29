<?php

namespace App\Controller;

use App\Repository\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CircuitController extends AbstractController
{

    private $entityManager;

    // Inyección del EntityManager en el constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/circuitos', name: 'circuit')]
    public function index(Request $request, CircuitRepository $circuitRepository): Response
    {

        $circuits = $circuitRepository->findAll();

        return $this->render('circuit/index.html.twig', [
            'circuits' => $circuits,
        ]);
    }
}
