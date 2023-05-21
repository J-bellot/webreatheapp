<?php

namespace App\Controller\Admin;

use App\Entity\Panne;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class PanneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Panne::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('module', 'Module'),
            DateTimeField::new('debut', 'Début de la panne'),
            DateTimeField::new('fin', 'Fin de la panne')->hideWhenCreating(),
            TextEditorField::new('description'),
            
        ];
    }
    
}
