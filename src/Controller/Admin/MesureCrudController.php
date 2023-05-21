<?php

namespace App\Controller\Admin;

use App\Entity\Mesure;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MesureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mesure::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('module', 'Module'),
            TextField::new('valeur', 'Valeur'),
            DateTimeField::new('date', 'Date et heure')
        ];
    }
    
}
