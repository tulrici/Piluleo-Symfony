<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Pilulier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('motDePasse', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('HistoriqueMedical')
            ->add('allergies', TextType::class, [
                'required' => false,
            ])
            ->add('adressePostale')
            ->add('CodePostal')
            ->add('ville')
            ->add('pays')
            ->add('pilulier', EntityType::class, [
                'class' => Pilulier::class,
                'choice_label' => 'id',
            ])
        ;

        $builder->get('allergies')
            ->addModelTransformer(new CallbackTransformer(
                function ($allergiesAsArray) {
                    return $allergiesAsArray ? implode(', ', $allergiesAsArray) : '';
                },
                function ($allergiesAsString) {
                    return $allergiesAsString ? array_map('trim', explode(',', $allergiesAsString)) : [];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
