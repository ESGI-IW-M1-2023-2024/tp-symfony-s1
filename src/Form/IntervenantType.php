<?php

namespace App\Form;

use App\Entity\Intervenant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class IntervenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
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
                'label' => 'Téléphone fixe/mobile',
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

            ->add('nom', null, [
                'label' => 'Nom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom doit avoir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas avoir plus de {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/',
                        'message' => 'Le nom ne peut contenir des chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Doe',
                ],
            ])
            ->add('prenom', null, [
                'label' => 'Prénom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit avoir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas avoir plus de {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/',
                        'message' => 'Le prénom ne peut contenir des chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'John',
                ],
            ])
            ->add('entreprise', null, [
                'label' => 'Entreprise',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom de l\'entreprise doit avoir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom de l\'entreprise ne peut pas avoir plus de {{ limit }} caractères.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Nom de l\'entreprise',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervenant::class,
        ]);
    }
}
