<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Metier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Métier',
                'attr' => [
                    'placeholder' => 'Intitulé du métier',
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
            'data_class' => Metier::class,
        ]);
    }
}
