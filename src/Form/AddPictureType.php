<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'label' => 'Nom de l\'image',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ])
                ]
            ])
            ->add('image', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire',
                    ]),
                    new Image([
                        'mimeTypes' => ['image/png', 'image/jpg', 'image/webp'],
                        'mimeTypesMessage' => 'Format d\'image non pris en compte'
                    ])
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
