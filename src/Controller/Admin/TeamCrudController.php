<?php

// src/Controller/Admin/TeamCrudController.php

namespace App\Controller\Admin;

use App\Entity\Team;
use App\Entity\Season;
use App\Entity\Driver;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('fullNameTeam', 'Nombre del Equipo'),
            TextField::new('base', 'Base del equipo')->setRequired(false),
            ImageField::new('urlTeamLogo', 'Foto Logo del Equipo')
                ->setBasePath('uploads/team_logos')
                ->setUploadDir('public/uploads/team_logos')
                ->setRequired(false)
                ->setSortable(false),
            ImageField::new('urlTeamCar', 'Foto del Coche')
                ->setBasePath('uploads/team_cars')
                ->setUploadDir('public/uploads/team_cars')
                ->setRequired(false)
                ->setSortable(false),
            TextField::new('teamChief', 'Jefe de Equipo')->setRequired(false),
            TextField::new('technicalChief', 'Jefe Técnico')->setRequired(false),
            AssociationField::new('seasonId', 'Temporada')->setFormTypeOption('choice_label', 'seasonName'),
        ];

        // Si estamos en la página de detalles (detalle del equipo)
        if ($pageName === Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('drivers', 'Pilotos')
                ->setFormTypeOption('by_reference', false)
                ->formatValue(function ($value, $entity) {
                    $drivers = $entity->getDrivers();
                    $links = [];
                    $seasonId = $entity->getSeasonId()->getId();  // Obtenemos el seasonId de la entidad Team (asegúrate de que esto sea correcto)
                    
                    foreach ($drivers as $driver) {
                        $links[] = sprintf(
                            '<a href="/admin/?crudAction=detail&crudControllerFqcn=%s&entityId=%d&seasonId=%d">%s</a>',
                            urlencode(DriverCrudController::class),
                            $driver->getId(),
                            $seasonId,  // Aquí agregamos el seasonId
                            htmlspecialchars($driver->getFullDriverName())
                        );
                    }
                    return implode(', ', $links);
                })
                ->onlyOnDetail();
        }

        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['fullNameTeam' => 'ASC'])
            ->setPaginatorPageSize(10)
            ->setPageTitle('new', 'Añadir escudería') // Para la página "New"
            ->setPageTitle('edit', 'Editar escudería') // Para la página "Edit"
            ->setPageTitle('detail', 'Detalle escudería') // Para la página "detail"
            ->setEntityLabelInSingular('Escudería')   // Etiqueta singular
            ->setEntityLabelInPlural('Escuderías');   // Etiqueta plural
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Botones en la página INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Añadir nueva escudería');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Editar');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Eliminar');
            })

            // Botones en la página NEW
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Guardar y añadir otra');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Guardar y volver');
            })

            // Botones en la página EDIT
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Guardar y volver');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('Guardar y continuar');
            });
    }
}
