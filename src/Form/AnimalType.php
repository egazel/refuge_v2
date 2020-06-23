<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
            [
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])

            ->add('age', NumberType::class,
            [
                'attr' => [
                    'placeholder' => 'Âge'
                ]
            ])
            ->add('sex', ChoiceType::class, [
                    'choices'  => [
                        'Male' => 'Male',
                        'Femelle' => 'Femelle',
                    ]
                 ]
            )
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce',
                    'placeholder' => 'Description de l\'animal'
                ],
            ])

            ->add('okDogs', CheckboxType::class, [
                'label'    => 'Ok chiens',
                'required' => false,
                ]
            )
            ->add('okCats', CheckboxType::class, [
                'label'    => 'Ok chats',
                'required' => false,
                ]
            )
            ->add('okKids', CheckboxType::class, [
                'label'    => 'Ok enfants',
                'required' => false,
                ]
            )
            ->add('adoptionPrice', MoneyType::class, [
                'divisor' => 1,
                'attr' => [
                    'placeholder' => 'Prix à l\'adoption'
                ]
            ])
            
            ->add('needCare', CheckboxType::class, [
                'label'    => 'Traitement particulier',
                'required' => false,
                ]
            )
            ->add(    
                'type',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Chien, chat...'
                    ]
                ]
            )

            ->add('race')

            ->add('imageLinks', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [ 
                    new File([
                        'maxSize' => '1024k',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
