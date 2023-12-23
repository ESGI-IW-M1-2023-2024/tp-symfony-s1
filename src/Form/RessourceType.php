<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Ressource;
use App\Form\EventListener\TransformFileUploadedListener;
use App\Service\FileUploader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RessourceType extends AbstractType
{
    public function __construct(
        private FileUploader $fileUploader
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'URL' => 'url',
                    'PDF' => 'pdf',
                ],
            'expanded' => false,
                'multiple' => false,
            ])
            ->add('url', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'URL de la ressource... ',
                ],
            'required' => false,
            ])
            ->add('contenu', FileType::class, [
                'attr' => [
                    'placeholder' => 'Contenu de la ressource... ',
                ],
            'required' => false,
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ],

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
