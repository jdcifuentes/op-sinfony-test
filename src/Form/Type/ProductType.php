<?php

namespace App\Form\Type;


use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, ['required' => true, 'label' => 'Código', 'attr' => ['minlength' => 4, 'maxlength' => 10]])
            ->add('name', TextType::class, ['required' => true, 'label' => 'Nombre', 'attr' => ['minlength' => 4]])
            ->add('description', TextareaType::class, ['required' => true, 'label' => 'Descripción'])
            ->add('brand', TextType::class, ['required' => true, 'label' => 'Marca'])
            ->add('category', ChoiceType::class, [
                'label' => 'Categoría',
                'required' => true,
                'choices' => $this->entityManager->getRepository(Category::class)->findAllActive(),
                'choice_label' => function (Category $category) {
                    return $category->getName();
                },
            ])
            ->add('price', MoneyType::class, ['required' => true, 'currency' => 'COP', 'label' => 'Precio'])
            ->add('save', SubmitType::class, ['label' => 'Guardar']);
    }
}