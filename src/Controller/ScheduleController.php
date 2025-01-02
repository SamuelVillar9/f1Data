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

    // Obtener la temporada seleccionada desde el formulario, o la temporada 2025 si no se ha seleccionado ninguna
    $seasonId = $request->query->get('season');
    
    // Si no hay temporada seleccionada, cargamos por defecto la temporada 2025
    if (!$seasonId) {
        $season = $this->entityManager->getRepository(Season::class)->findOneBy(['seasonName' => '2025']);
    } else {
        // Si se seleccionó una temporada, la buscamos
        $season = $this->entityManager->getRepository(Season::class)->find($seasonId);
    }

    // Obtener los calendarios de la temporada seleccionada
    if ($season) {
        $schedules = $scheduleRepository->findBy(['seasonId' => $season]);
    } else {
        $schedules = $scheduleRepository->findAll(); // Si no se encuentra temporada, mostramos todos los calendarios
    }

    return $this->render('schedule/index.html.twig', [
        'schedules' => $schedules,
        'seasons' => $seasons,
        'selectedSeason' => $season ? $season->getId() : null,
    ]);
}
}
