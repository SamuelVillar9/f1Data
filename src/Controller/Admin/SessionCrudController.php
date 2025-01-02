<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('sessionName', 'Nombre de la Sesión')
                ->formatValue(function ($value, $entity) {
                    // Generamos la URL del detalle de la sesión
                    $url = sprintf(
                        '/admin/?crudAction=detail&crudControllerFqcn=App\\Controller\\Admin\\SessionCrudController&entityId=%d&meetingId=%d',
                        $entity->getId(),
                        $entity->getMeetingId()->getId()  // Asumimos que tienes una relación con la temporada y obtenemos su ID
                    );

                    // Devolvemos el nombre del equipo como un enlace
                    return sprintf('<a href="%s">%s</a>', $url, $value);
                }),
            TextField::new('forecast', 'Previsión del tiempo'),
            DateField::new('date', 'Fecha y hora'),
            AssociationField::new('meetingId', 'Gran Premio')->setFormTypeOption('choice_label', function ($meeting) {
                return $meeting->getMeetingName();
            }),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'ASC'])
            ->setPaginatorPageSize(10)
            ->setPageTitle('new', 'Añadir sesión') // Para la página "New"
            ->setPageTitle('edit', 'Editar sesión') // Para la página "Edit"
            ->setPageTitle('detail', 'Detalle sesión') // Para la página "detail"
            ->setEntityLabelInSingular('Sesión')   // Etiqueta singular
            ->setEntityLabelInPlural('Sesiones');   // Etiqueta plural
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Botones en la página INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Añadir nueva sesión');
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
