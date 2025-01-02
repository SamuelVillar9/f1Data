<?php

namespace App\Controller\Admin;

use App\Entity\Season;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class SeasonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }


    public function configureFields(string $pageName): iterable
    {
        // Si estamos en la página de índice, generamos un enlace para el nombre de la temporada
        if ($pageName === Crud::PAGE_INDEX) {
            return [
                TextField::new('seasonName', 'Temporada')
                    ->formatValue(function ($value, $entity) {
                        // Generamos la URL del detalle de la temporada
                        $url = sprintf(
                            '/admin/?crudAction=detail&crudControllerFqcn=App\\Controller\\Admin\\SeasonCrudController&entityId=%d&seasonId=%d',
                            $entity->getId(),
                            $entity->getId()  // Asumimos que el ID de la temporada es el mismo para 'entityId' y 'seasonId'
                        );

                        // Devolvemos el nombre de la temporada como un enlace
                        return sprintf('<a href="%s">%s</a>', $url, $value);
                    })
                    ->setSortable(true),
            ];
        }

        // Para otras páginas, solo mostramos el nombre de la temporada
        return [
            TextField::new('seasonName', 'Temporada')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPageTitle('new', 'Añadir temporada') // Para la página "New"
            ->setPageTitle('edit', 'Editar temporada') // Para la página "Edit"
            ->setPageTitle('detail', 'Detalle temporada') // Para la página "detail"
            ->setEntityLabelInSingular('Temporada')   // Etiqueta singular
            ->setEntityLabelInPlural('Temporadas');   // Etiqueta plural
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Botones en la página INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Añadir nueva temporada');
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
