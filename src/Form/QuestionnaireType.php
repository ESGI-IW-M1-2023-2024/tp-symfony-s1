<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Questionnaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 50);

        $builder
            ->add('annee', ChoiceType::class, [
                'choices' => array_combine($years, $years),
            'placeholder' => 'Choix de l\'année',
            ])
            ->add('questions', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'intitule',
                'multiple' => true,
                'placeholder' => 'Choix des questions',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}
