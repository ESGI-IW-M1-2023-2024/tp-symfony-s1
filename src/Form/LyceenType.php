<?php

namespace App\Form;

use App\Entity\Lycee;
use App\Entity\Lyceen;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LyceenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('telephone')
            ->add('dateInscription')
            ->add('section')
            ->add('lycee', EntityType::class, [
                'class' => Lycee::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lyceen::class,
        ]);
    }
}
