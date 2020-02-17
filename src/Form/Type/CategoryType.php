<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, ['required' => true, 'label' => 'Código'])
            ->add('name', TextType::class, ['required' => true, 'label' => 'Nombre', 'attr' => ['minlength' => 2]])
            ->add('description', TextareaType::class, ['required' => true, 'label' => 'Descripción'])
            ->add('active', ChoiceType::class, [
                'label' => 'Activo',
                'choices' => [
                    'Activo' => 1,
                    'Inactivo' => 0,

                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Guardar']);
    }
}