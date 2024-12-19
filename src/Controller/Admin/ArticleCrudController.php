<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('tagline'),
            TextareaField::new('description'),
            TextField::new('slug')->setRequired(false),
            AssociationField::new('tags')->setFormTypeOption(
                'by_reference',
                false
            ),
            TextEditorField::new('content')->setFormTypeOptions([
                'block_name' => 'field_code_editor_widget',
            ]),
            DateField::new('publishedAt'),
            DateField::new('createdAt')->onlyOnIndex(),
        ];
    }
}
