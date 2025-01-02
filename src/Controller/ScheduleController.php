<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Season;

use Symfony\Component\HttpFoundation\Request;

class ScheduleController extends AbstractController
{

    private $entityManager;

    // Inyección del EntityManager en el constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/calendario', name: 'schedule')]
    public function index(Request $request, ScheduleRepository $scheduleRepository): Response
    {

        // Obtener todas las temporadas desde el repositorio
        $seasons = $this->entityManager->getRepository(Season::class)->findBy([], ['seasonName' => 'ASC']);

        // Capturar el ID de la temporada seleccionada desde el formulario (si lo hay)
        $seasonId = $request->query->get('season');

        if ($seasonId) {
            // Buscar la temporada seleccionada
            $season = $this->entityManager->getRepository(Season::class)->find($seasonId);

            // Obtener los pilotos de esa temporada
            $schedules = $scheduleRepository->findBy(['seasonId' => $season]);
        } else {
            // Si no se seleccionó ninguna temporada, mostrar todos los pilotos
            $schedules = $scheduleRepository->findAll();
        }

        return $this->render('schedule/index.html.twig', [
            'schedules' => $schedules,
            'seasons' => $seasons,  // Enviar las temporadas a la vista
        ]);
    }
}
