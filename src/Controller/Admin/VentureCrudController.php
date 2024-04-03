<?php

namespace App\Controller\Admin;

use App\Entity\Venture;
use App\Enum\VentureStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

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
            ChoiceField::new('status')->setFormType(EnumType::class)->setFormTypeOptions([
                'class' => VentureStatusEnum::class,
                'choice_label' => function (VentureStatusEnum $choice, $key, $value) {
                    return $choice->value;
                },
                'choices' => VentureStatusEnum::cases(),
            ])->setRequired(false),
        ];
    }
}
