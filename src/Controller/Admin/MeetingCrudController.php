<?php

namespace App\Controller\Admin;

use App\Entity\Meeting;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class MeetingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Meeting::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('meetingName', 'Nombre del GP'),
            IntegerField::new('roundNumber', 'Ronda'),
            TextField::new('dates', 'Fechas GP'),
            IntegerField::new('raceLaps', 'Vueltas'),
            AssociationField::new('circuitId', 'Circuito'),
            AssociationField::new('scheduleId', 'Calendario'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['scheduleId' => 'desc'],['id', 'asc'], ['roundNumber' => 'asc'])
            ->setPaginatorPageSize(10)
            ->setPageTitle('new', 'Añadir Gran Premio') // Para la página "New"
            ->setPageTitle('edit', 'Editar Gran Premio') // Para la página "Edit"
            ->setPageTitle('detail', 'Detalle Gran Premio') // Para la página "detail"
            ->setEntityLabelInSingular('Gran Premio')   // Etiqueta singular
            ->setEntityLabelInPlural('Grandes Premios');   // Etiqueta plural
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Botones en la página INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Añadir nuevo gran premio');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Editar');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Eliminar');
            })

            // Botones en la página NEW
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Guardar y añadir otro');
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
