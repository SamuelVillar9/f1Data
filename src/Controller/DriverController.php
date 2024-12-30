<?php

namespace App\Controller;

use App\Entity\Season;
use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class DriverController extends AbstractController
{

    private $entityManager;

    // Inyección del EntityManager en el constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/pilotos', name: 'driver')]
    public function index(Request $request, DriverRepository $driverRepository): Response
    {   
        // Obtener todas las temporadas desde el repositorio
        $seasons = $this->entityManager->getRepository(Season::class)->findBy([], ['seasonName' => 'ASC']);
        
        // Capturar el ID de la temporada seleccionada desde el formulario (si lo hay)
        $seasonId = $request->query->get('season');
        
        if ($seasonId) {
            // Buscar la temporada seleccionada
            $season = $this->entityManager->getRepository(Season::class)->find($seasonId);
            
            // Obtener los pilotos de esa temporada
            $drivers = $driverRepository->findBy(['season' => $season]);
        } else {
            // Si no se seleccionó ninguna temporada, mostrar todos los pilotos
            $drivers = $driverRepository->findAll();
        }

        return $this->render('driver/index.html.twig', [
            'drivers' => $drivers,
            'seasons' => $seasons,  // Enviar las temporadas a la vista
        ]);
    }
}
