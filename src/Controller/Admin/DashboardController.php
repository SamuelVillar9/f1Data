<?php

namespace App\Controller\Admin;

use App\Entity\Circuit;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Season;
use App\Entity\Team;
use App\Entity\Driver;
use App\Entity\Meeting;
use App\Entity\Schedule;
use App\Entity\Session;

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
        // Contamos el número de registros de cada entidad
        $circuitCount = $this->entityManager->getRepository(Circuit::class)->count([]);
        $driverCount = $this->entityManager->getRepository(Driver::class)->count([]);
        $meetingCount = $this->entityManager->getRepository(Meeting::class)->count([]);
        $scheduleCount = $this->entityManager->getRepository(Schedule::class)->count([]);
        $seasonCount = $this->entityManager->getRepository(Season::class)->count([]);
        $sessionCount = $this->entityManager->getRepository(Session::class)->count([]);
        $teamCount = $this->entityManager->getRepository(Team::class)->count([]);

        // Pasamos los resultados al template
        return $this->render('admin/dashboard.html.twig', [
            'circuitCount' => $circuitCount,
            'driverCount' => $driverCount,
            'meetingCount' => $meetingCount,
            'scheduleCount' => $scheduleCount,
            'seasonCount' => $seasonCount,
            'sessionCount' => $sessionCount,
            'teamCount' => $teamCount,
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
        yield MenuItem::section('GESTIÓN DE DATOS');
        yield MenuItem::linkToCrud('Temporadas', 'fa fa-solid fa-list', Season::class);
        yield MenuItem::linkToCrud('Escuderías', 'fa fa-solid fa-people-group', Team::class);
        yield MenuItem::linkToCrud('Pilotos', 'fa fa-solid fa-id-card', Driver::class);
        yield MenuItem::linkToCrud('Circuitos', 'fa fa-solid fa-ring', Circuit::class);
        yield MenuItem::linkToCrud('Calendario', 'fa fa-solid fa-calendar-days', Schedule::class);
        yield MenuItem::linkToCrud('Grandes Premios', 'fa fa-solid fa-earth-europe', Meeting::class);
        yield MenuItem::section('VISTA PÚBLICA');
        yield MenuItem::linkToUrl('Calendario', 'fa fa-solid fa-calendar-days', '/calendario');
        yield MenuItem::linkToUrl('Escuderías', 'fa fa-solid fa-people-group', '/escuderias');
        yield MenuItem::linkToUrl('Pilotos', 'fa fa-solid fa-id-card', '/pilotos');
        yield MenuItem::linkToUrl('Circuitos', 'fa fa-solid fa-ring', '/circuitos');
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Cerrar Sesión', 'fa fa-sign-out');
    }
}
