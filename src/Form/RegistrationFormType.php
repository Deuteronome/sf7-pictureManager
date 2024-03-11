<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'required' => 'true'
                ],
                'label' => 'Code d\'inscription',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 10,                       
                        'exactMessage' => 'Code invalide',                       
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'required' => 'true'
                ],
                'label' => 'E-mail',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'required' => 'true'
                ],
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'required' => 'true'
                ],
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                            'class' => 'form-control mb-2',
                            'required' => 'true'
                ],
                'label' => 'Mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'longueur minimum :  {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
