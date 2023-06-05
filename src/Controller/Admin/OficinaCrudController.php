<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Entity\Oficina;
use App\Entity\Localidad;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OficinaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Oficina::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('oficina'),
            Associationfield::new('localidad')
        ];
    }


    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
