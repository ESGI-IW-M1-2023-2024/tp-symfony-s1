<?php

namespace App\Form;

use App\Entity\Lycee;
use App\Entity\Lyceen;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LyceenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'nom@lycee.fr',
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('telephone', null, [
                'attr' => [
                    'placeholder' => '0612345678',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('section', ChoiceType::class, [
                'choices' => [
                    'Seconde' => 'seconde',
                    'Première' => 'Premiere',
                    'Terminale' => 'terminale',
                ],
                'data' => 'seconde',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('lycee', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Lycee::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lyceen::class,
        ]);
    }
}
