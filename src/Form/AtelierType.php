<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Intervenant;
use App\Entity\Lyceen;
use App\Entity\Salle;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('heure')
            ->add('secteur', EntityType::class, [
                'class' => Secteur::class,
'choice_label' => 'id',
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
'choice_label' => 'id',
            ])
            ->add('intervenants', EntityType::class, [
                'class' => Intervenant::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('lyceens', EntityType::class, [
                'class' => Lyceen::class,
'choice_label' => 'id',
'multiple' => true,
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
