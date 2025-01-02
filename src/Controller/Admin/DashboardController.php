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

        // Submenú para 'Temporadas'
        yield MenuItem::subMenu('Temporadas', 'fa fa-solid fa-list')->setSubItems([
            MenuItem::linkToCrud('Añadir Temporada', 'fa fa-solid fa-plus', Season::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Temporadas', 'fa fa-solid fa-list', Season::class)->setAction('index')
        ]);

        // Submenú para 'Escuderías'
        yield MenuItem::subMenu('Escuderías', 'fa fa-solid fa-people-group')->setSubItems([
            MenuItem::linkToCrud('Añadir Escudería', 'fa fa-solid fa-plus', Team::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Escuderías', 'fa fa-solid fa-list', Team::class)->setAction('index')
        ]);

        // Submenú para 'Pilotos'
        yield MenuItem::subMenu('Pilotos', 'fa fa-solid fa-id-card')->setSubItems([
            MenuItem::linkToCrud('Añadir Piloto', 'fa fa-solid fa-plus', Driver::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Pilotos', 'fa fa-solid fa-list', Driver::class)->setAction('index')
        ]);

        // Submenú para 'Circuitos'
        yield MenuItem::subMenu('Circuitos', 'fa fa-solid fa-ring')->setSubItems([
            MenuItem::linkToCrud('Añadir Circuito', 'fa fa-solid fa-plus', Circuit::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Circuitos', 'fa fa-solid fa-list', Circuit::class)->setAction('index')
        ]);

        // Submenú para 'Calendario'
        yield MenuItem::subMenu('Calendario', 'fa fa-solid fa-calendar-days')->setSubItems([
            MenuItem::linkToCrud('Añadir Carrera', 'fa fa-solid fa-plus', Schedule::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Carreras', 'fa fa-solid fa-list', Schedule::class)->setAction('index')
        ]);

        // Submenú para 'Grandes Premios'
        yield MenuItem::subMenu('Grandes Premios', 'fa fa-solid fa-earth-europe')->setSubItems([
            MenuItem::linkToCrud('Añadir Gran Premio', 'fa fa-solid fa-plus', Meeting::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Grandes Premios', 'fa fa-solid fa-list', Meeting::class)->setAction('index')
        ]);

        // Submenú para 'Sesiones'
        yield MenuItem::subMenu('Sesiones', 'fa fa-solid fa-stopwatch')->setSubItems([
            MenuItem::linkToCrud('Añadir Sesión', 'fa fa-solid fa-plus', Session::class)->setAction('new'),
            MenuItem::linkToCrud('Listar Sesiones', 'fa fa-solid fa-list', Session::class)->setAction('index')
        ]);

        // Sección para enlaces públicos
        yield MenuItem::section('VISTA PÚBLICA');
        yield MenuItem::linkToUrl('Calendario', 'fa fa-solid fa-calendar-days', '/calendario');
        yield MenuItem::linkToUrl('Escuderías', 'fa fa-solid fa-people-group', '/escuderias');
        yield MenuItem::linkToUrl('Pilotos', 'fa fa-solid fa-id-card', '/pilotos');
        yield MenuItem::linkToUrl('Circuitos', 'fa fa-solid fa-ring', '/circuitos');

        // Cerrar sesión
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Cerrar Sesión', 'fa fa-sign-out');
    }
}
