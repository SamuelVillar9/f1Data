<?php

namespace App\Controller;

use App\Entity\Season;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TeamController extends AbstractController
{
    private $entityManager;

    // Inyección del EntityManager en el constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/escuderias', name: 'team')]
    public function index(Request $request, TeamRepository $teamRepository): Response
    {
        // Obtener todas las temporadas desde el repositorio
        $seasons = $this->entityManager->getRepository(Season::class)->findAll();
        
        // Capturar el ID de la temporada seleccionada desde el formulario (si lo hay)
        $seasonId = $request->query->get('season_id');
        
        if ($seasonId) {
            // Buscar la temporada seleccionada
            $season = $this->entityManager->getRepository(Season::class)->find($seasonId);
            
            // Obtener los equipos de esa temporada
            $teams = $teamRepository->findBy(['seasonId' => $season]);
        } else {
            // Si no se seleccionó ninguna temporada, mostrar todos los equipos
            $teams = $teamRepository->findAll();
        }

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
            'seasons' => $seasons,  // Enviar las temporadas a la vista
        ]);
    }
}
