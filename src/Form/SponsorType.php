<?php

namespace App\Form;

use App\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 200);

        $builder
            ->add('logo', FileType::class, [
                'label' => 'Logo',
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                ],
            ])
            ->add('nom', null, [
                'label' => 'Nom du sponsor',
                'attr' => [
                    'placeholder' => 'Nom du sponsor'
                ]
            ])
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez une URL',
                ],
            ])
            ->add('annee', ChoiceType::class, [
                'choices' => array_combine($years, $years),
                'placeholder' => $currentYear,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
