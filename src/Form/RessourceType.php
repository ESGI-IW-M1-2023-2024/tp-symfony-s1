<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Ressource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'URL' => 'url',
                    'PDF' => 'pdf',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('Contenu', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Contenu de la ressource... ',
                ],
            ])
            ->add('atelier', EntityType::class, [
                'class' => Atelier::class,
                'choice_label' => 'nom',
                'placeholder' => 'Séléctionner l\'atelier',
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
