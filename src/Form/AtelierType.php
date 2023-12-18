<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Intervenant;
use App\Entity\Lyceen;
use App\Entity\Salle;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom de l\'atelier',
                 'attr' => [
                    'placeholder' => 'Atelier',
                ],
            ])
            ->add('heure', ChoiceType::class, [
                'label' => 'Créneau horaire',
                'choices' => [
                    '9h30' => '9:30',
                    '10h30' => '10:30',
                    '11h30' => '11:30',
                ]
            ])
            ->add('secteur', EntityType::class, [
                'class' => Secteur::class,
                'choice_label' => 'nom',
                'placeholder' => 'Séléctionner du secteur',
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => 'nom',
                'placeholder' => 'Séléctionner la salle',
            ])
            ->add('intervenants', EntityType::class, [
                'class' => Intervenant::class,
                'choice_label' => 'email',
                'multiple' => true,
                'placeholder' => 'Intervenants disponible',
            ])
            ->add('lyceens', EntityType::class, [
                'class' => Lyceen::class,
                'choice_label' => 'email',
                'multiple' => true,
                'placeholder' => 'Lycéens participants',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Atelier::class,
        ]);
    }
}
