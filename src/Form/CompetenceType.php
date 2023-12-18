<?php

namespace App\Form;

use App\Entity\Competence;
use App\Entity\Metier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('metier', EntityType::class, [
                'class' => Metier::class,
                'choice_label' => 'nom',
                'placeholder' => 'Séléctionner le métier',
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter une description ...',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competence::class,
        ]);
    }
}
