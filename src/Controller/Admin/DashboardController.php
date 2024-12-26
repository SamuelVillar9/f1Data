<?php

namespace App\Controller\Admin;

use App\Entity\Circuit;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Season;
use App\Entity\Team;
use App\Entity\Driver;

class DashboardController extends AbstractDashboardController
{
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $selectedSeasonId = $request->query->get('season_id', null);

        $seasons = $this->entityManager->getRepository(Season::class)->findAll();

        $teams = [];
        if ($selectedSeasonId) {
            $season = $this->entityManager->getRepository(Season::class)->find($selectedSeasonId);
            if ($season) {
                $teams = $season->getTeams();
            }
        }

        // Generar URLs para cada equipo
        $teamUrls = [];
        foreach ($teams as $team) {
            $teamUrls[$team->getId()] = $this->adminUrlGenerator
                ->setController(TeamCrudController::class)
                ->setAction('detail') // Cambiar a 'edit' si prefieres la vista de edición
                ->setEntityId($team->getId())
                ->generateUrl();
        }

        return $this->render('admin/dashboard.html.twig', [
            'seasons' => $seasons,
            'teams' => $teams,
            'selectedSeasonId' => $selectedSeasonId,
            'teamUrls' => $teamUrls,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('F1Data Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Seasons', 'fa fa-solid fa-calendar', Season::class);
        yield MenuItem::linkToCrud('Teams', 'fa fa-solid fa-people-group', Team::class);
        yield MenuItem::linkToCrud('Drivers', 'fa fa-solid fa-id-card', Driver::class);
        yield MenuItem::linkToCrud('Circuits', 'fa fa-solid fa-ring', Circuit::class);
    }
}
