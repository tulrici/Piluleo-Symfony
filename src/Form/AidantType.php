<?php

namespace App\Form;

use App\Entity\Aidant;
use App\Entity\Notification;
use App\Entity\Traitement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AidantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('motDePasse')
            ->add('specialisation')
            ->add('notifications', EntityType::class, [
                'class' => Notification::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('traitement', EntityType::class, [
                'class' => Traitement::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aidant::class,
        ]);
    }
}
