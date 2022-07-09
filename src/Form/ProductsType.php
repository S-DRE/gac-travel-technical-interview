<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre'
            ])
            /*
            ->add('created_at', DateType::class, [
                'widget' => 'single_text'
            ])
            */
            ->add('stock')
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'query_builder' => function (CategoriesRepository $repo) {
                    return $repo->createQueryBuilder('cat')
                        ->orderBy('cat.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Categoría'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
