<?php

declare(strict_types=1);

namespace App\Form\Filter;

use App\DataTransferObject\ArticleFilterDto;
use App\Entity\Tag;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ArticleFilter extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod(Request::METHOD_GET)
            ->add('keyword', TextType::class, [
                'required' => false,
                'label' => $this->translator->trans('keyword'),
                'attr' => [
                    'placeholder' => $this->translator->trans('keyword'),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('tags', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Tag::class,
                'multiple' => true,
                'choice_label' => 'content',
                'autocomplete' => true,
                'attr' => [
                    'placeholder' => $this->translator->trans('tags'),
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleFilterDto::class,
        ]);
    }
}
