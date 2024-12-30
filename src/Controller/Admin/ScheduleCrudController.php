<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('scheduleName', 'Nombre Calendario'),
            AssociationField::new('seasonId', 'Temporada')->setFormTypeOption('choice_label', 'seasonName'),
        ];

        // Si estamos en la página de detalles, mostrar los meetings asociados
        if ($pageName === Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('meetings', 'Grandes Premios')
                ->setFormTypeOption('by_reference', false)
                ->onlyOnDetail() // Solo mostrar en detalle
                ->formatValue(function ($value, $entity) {
                    $meetings = $entity->getMeetings();
                    $cards = [];

                    // Iniciar la fila de tarjetas
                    $rowOpen = '<div class="row">';

                    // Generar una tarjeta (card) para cada meeting
                    foreach ($meetings as $index => $meeting) {
                        // Crear el contenido de la tarjeta
                        $card = sprintf(
                            '<div class="col-md-3 mb-3">
                            <div class="card h-100"> <!-- Usamos h-100 para asegurar que todas las cards tengan la misma altura -->
                                <div class="card-header text-truncate">GP %s</div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-truncate">%s</h5>
                                    <p class="card-text">%s</p>
                                    <p class="card-text">%s</p
                                    <a href="/admin/?crudAction=detail&crudControllerFqcn=%s&entityId=%d" class="btn btn-primary mt-auto">Ver detalles</a>
                                </div>
                            </div>
                        </div>',
                            // La ronda del meeting
                            htmlspecialchars($meeting->getRoundNumber()),
                            // El nombre del meeting (usado como título de la tarjeta)
                            htmlspecialchars($meeting->getMeetingName()),
                            // Mostrar las fechas de la carrera
                            htmlspecialchars($meeting->getDates()),
                            // Mostrar el nombre del circuito
                            htmlspecialchars($meeting->getCircuitId()->getCircuitName()),
                            // Controlador y ID para enlazar a la página de detalles del meeting
                            urlencode(MeetingCrudController::class),
                            $meeting->getId()
                        );

                        // Añadir la tarjeta a la fila
                        $cards[] = $card;

                        // Si hemos llegado a 4 tarjetas, cerramos la fila y abrimos una nueva
                        if (($index + 1) % 4 == 0) {
                            $rowClose = '</div>'; // Cerrar la fila
                            $rowOpen = '<div class="row">'; // Abrir una nueva fila
                            $cards[] = $rowClose;
                            $cards[] = $rowOpen;
                        }
                    }

                    // Si quedan tarjetas sin cerrar, cerramos la última fila
                    if (count($cards) % 4 != 0) {
                        $cards[] = '</div>'; // Cerrar la última fila
                    }

                    // Devolver el HTML para todas las cards
                    return $rowOpen . implode('', $cards);
                });
        }

        return $fields;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['scheduleName' => 'DESC'])
            ->setPaginatorPageSize(10)
            ->setPageTitle('new', 'Añadir Calendario') // Página "New"
            ->setPageTitle('edit', 'Editar Calendario') // Página "Edit"
            ->setPageTitle('detail', 'Detalle Calendario') // Página "Detail"
            ->setEntityLabelInSingular('Calendario')   // Etiqueta singular
            ->setEntityLabelInPlural('Calendarios');   // Etiqueta plural
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Añadir nuevo calendario');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Editar');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Eliminar');
            })
            // Más configuraciones para acciones en las páginas NEW y EDIT...
        ;
    }
}
