<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Questionnaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', null, [
                'label' => 'Intitulé',
                'attr' => [
                    'placeholder' => 'Intitulé de la question',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                'ouverte' => 'open',
                'fermée' => 'close',
                ],
                'expanded' => true,
                'multiple' => false,
        ])
            ->add('choices', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Choix d\'une réponse',
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Choix possibles de réponse (si fermée)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
