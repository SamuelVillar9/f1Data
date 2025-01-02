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
                    $listItems = [];

                    // Generar una lista con cada meeting
                    foreach ($meetings as $meeting) {
                        $listItems[] = sprintf(
                            '<li class="list-group-item">
                                <strong>GP %s: </strong> %s <br>
                                <em>%s</em><br>
                                <span><strong>Circuito:</strong> %s</span><br>
                                <a href="/admin/?crudAction=detail&crudControllerFqcn=%s&entityId=%d" class="btn btn-primary mt-2">Ver detalles</a>
                            </li>',
                            // La ronda del meeting
                            htmlspecialchars($meeting->getRoundNumber()),
                            // El nombre del meeting
                            htmlspecialchars($meeting->getMeetingName()),
                            // Mostrar las fechas de la carrera
                            htmlspecialchars($meeting->getDates()),
                            // Mostrar el nombre del circuito
                            htmlspecialchars($meeting->getCircuitId()->getCircuitName()),
                            // Controlador y ID para enlazar a la página de detalles del meeting
                            urlencode(MeetingCrudController::class),
                            $meeting->getId()
                        );
                    }

                    // Devolver el HTML de la lista de meetings
                    return '<ul class="list-group">' . implode('', $listItems) . '</ul>';
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
            });
    }
}
