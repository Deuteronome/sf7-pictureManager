<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordRenewalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'my-2 form-control'
                ],
                'label' => 'Nouveau mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choisissez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => '{{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'my-2 form-control'
                ],
                'label' => 'Confirmez votre mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Confirmez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => '{{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
