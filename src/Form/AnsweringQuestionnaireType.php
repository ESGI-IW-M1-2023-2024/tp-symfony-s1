<?php

namespace App\Form;

use App\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnsweringQuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['questions'] as $question) {
            if ($question->getType() === 'open') {
                $builder->add($question->getId(), TextType::class, [
                    'label' => $question->getIntitule(),
                    'mapped' => false,
                ]);
            } else {
                $builder->add($question->getId(), ChoiceType::class, [
                    'label' => $question->getIntitule(),
                    'mapped' => false,
                    'choices' => $question->getChoices(),
                    'choice_label' => function ($choice) {
                        return $choice;
                    },
                    'expanded' => true,
                    'multiple' => false,
                ]);
            }
        }
        $builder->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => null,
            'questions' => [],
        ]);
    }
}
