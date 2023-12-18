<?php

namespace App\Form;

use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $nombreEtages = 15;
        $etages = [];

        for ($i = 0; $i <= $nombreEtages; $i++) {
            if($i == 0){
                $etages['Rez-de-chaussée'] = "etage_$i";
                continue;
            }
            $etages["Étage $i"] = "etage_$i";
        }

        $builder
            ->add('nom', null, [
                'label' => "Nom de la salle",
                'attr' => [
                    'placeholder' => 'Salle 501',
                ],
            ])
            ->add('etage' ,  ChoiceType::class, [
                'label' => "Étage",
                'choices' => $etages,
                'placeholder' => 'Sélectionnez l\'étage',
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité',
                'attr' => [
                    'min' => 1,
                    'max' => 1000,
                    'placeholder' => '50',
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}
