<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('age')
            ->add('sex')
            ->add('description')
            ->add('okDogs')
            ->add('okCats')
            ->add('okKids')
            ->add('adoptionPrice')
            ->add('dateAdd')
            ->add('fur')
            ->add('needCare')
            ->add('type')
            ->add('isHosted')
            // ->add('FA')
            // ->add('member')
            // ->add('gerant')
            // ->add('race')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
