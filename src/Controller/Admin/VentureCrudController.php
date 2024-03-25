<?php

namespace App\Controller\Admin;

use App\Entity\Venture;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class VentureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Venture::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            UrlField::new('url')->setRequired(false),
            TextField::new('description')->setRequired(false),
        ];
    }
}
