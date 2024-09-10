<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Pilulier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('motDePasse')
            ->add('HistoriqueMedical')
            ->add('allergies')
            ->add('adressePostale')
            ->add('CodePostal')
            ->add('ville')
            ->add('pays')
            ->add('pilulier', EntityType::class, [
                'class' => Pilulier::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
