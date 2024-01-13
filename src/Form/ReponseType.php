<?php

namespace App\Form;

use App\Entity\Lyceen;
use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'intitule',
                'placeholder' => 'Séléctionner la question',
            ])
            ->add('lyceen', EntityType::class, [
                'label' => 'Lycéen',
                'class' => Lyceen::class,
                'choice_label' => 'email',
                'placeholder' => 'Séléctionner le lycéen',
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Contenu de la réponse',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
