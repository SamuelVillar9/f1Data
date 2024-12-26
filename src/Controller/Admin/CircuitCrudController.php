<?php

namespace App\Controller\Admin;

use App\Entity\Circuit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class CircuitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Circuit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('circuitName', 'Nombre del Circuito'),
            TextField::new('location', 'Ubicación'),
            TextField::new('country', 'País'),
            TextField::new('lengthKm','Longitud (Km)'),

            // Configurar los campos de imagen para las fotos del circuito
            ImageField::new('urlCircuitPhoto', 'Foto del Circuito')
                ->setBasePath('uploads/circuits')  // Ruta base para acceder a las imágenes
                ->setUploadDir('public/uploads/circuits')  // Ruta donde se almacenarán las imágenes en el servidor
                ->setRequired(false)
                ->setSortable(false), // Evita ordenar por este campo

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPageTitle('new', 'Añadir circuito') // Para la página "New"
            ->setPageTitle('edit', 'Editar circuito') // Para la página "Edit"
            ->setPageTitle('detail', 'Detalle circuito') // Para la página "detail"
            ->setEntityLabelInSingular('Circuito')   // Etiqueta singular
            ->setEntityLabelInPlural('Circuitos');   // Etiqueta plural
            
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Botones en la página INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Añadir nuevo circuito');
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
