<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('active')
            ->add('createdAt')
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    // 'Mod' => 'ROLE_MOD',
                    // 'User' => 'ROLE_USER'
                ]
            ])
            ->add('password')
            ->add('isVerified')
        ;

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                return count($rolesArray) ? $rolesArray[0] : null;
            },
            function($rolesString) {
                return [$rolesString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
