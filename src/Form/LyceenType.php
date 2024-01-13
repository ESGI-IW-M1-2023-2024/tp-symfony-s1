<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Lycee;
use App\Entity\Lyceen;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class LyceenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Adresse e-mail",
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse email "{{ value }}" n\'est pas valide.',
                        'mode' => 'strict',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'example@email.com',
                ],
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone mobile',
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 14,
                        'minMessage' => 'Le numéro de téléphone doit avoir au moins {{ limit }} chiffres.',
                        'maxMessage' => 'Le numéro de téléphone ne peut pas avoir plus de {{ limit }} chiffres.',
                    ]),
                    new Regex([
                        'pattern' => '/^\+?\d+$/',
                        'message' => 'Le numéro de téléphone doit contenir uniquement des chiffres et éventuellement commencer par un signe plus (+).',
                    ]),
                ],
                'attr' => [
                    'placeholder' => '06 XX XX XX XX',
                ],
            ])
            ->add('section', ChoiceType::class, [
                'choices' => [
                    'Seconde' => 'Seconde',
                    'Première' => 'Première',
                    'Terminale' => 'Terminale',
                ],
            ])
            ->add('lycee', EntityType::class, [
                'label' => 'Lycée',
                'class' => Lycee::class,
                'choice_label' => 'nom',
            ])
            ->add('atelier_1', EntityType::class, [
                'label' => 'Choix Atelier 1',
                'class' => Atelier::class,
                'mapped' => false,
                'choice_label' => 'nom',
                'group_by' => function(Atelier $atelier) {
                    return $atelier->getHeure();
                },
                'multiple' => false,
                'expanded' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir au moins un atelier.',
                    ]),
                ]
            ])->add('atelier_2', EntityType::class, [
                'label' => 'Choix Atelier 2',
                'class' => Atelier::class,
                'mapped' => false,
                'choice_label' => 'nom',
                'group_by' => function(Atelier $atelier) {
                    return $atelier->getHeure();
                },
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'placeholder' => "Pas d'atelier",
                'empty_data' => null,
            ])->add('atelier_3', EntityType::class, [
                'label' => 'Choix Atelier 3',
                'class' => Atelier::class,
                'mapped' => false,
                'choice_label' => 'nom',
                'group_by' => function(Atelier $atelier) {
                    return $atelier->getHeure();
                },
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'empty_data' => null,
                'placeholder' => "Pas d'atelier",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lyceen::class,
        ]);
    }
}
