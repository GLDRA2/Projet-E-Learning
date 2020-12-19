<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Upload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Title',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextType::class,[
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ])
            ->add('file_vedio', TextType::class,[
                'label' => 'Vedio Url',
                'attr' => ['class' => 'form-control',
                            'placeholder' => 'https://www.youtube.com/'
                ]
            ])
            ->add('file_pdf', FileType::class,[
                'label' => 'PDF File',
                'required'=> false,
                'attr' => ['class' => 'form-control-file']
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Upload::class,
        ]);
    }
}
