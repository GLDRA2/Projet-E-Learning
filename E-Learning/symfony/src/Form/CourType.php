<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextType::class,[
                'label' => 'Desciption',
                'attr' => ['class' => 'form-control']
            ])
            ->add('section', TextType::class,[
                'label' => 'Section',
                'attr' => ['class' => 'form-control']
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'custom-select form-control']
            ])
            ->add('image', FileType::class,[
                'data_class' => null,
                'required' => false,
                'label' => 'Enter Image',
                'attr' => ['class' => 'form-control-file']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
