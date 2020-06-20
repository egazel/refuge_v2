<?php

namespace App\Form;

use App\Entity\FA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberToFosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hasDog')
            ->add('hasCat')
            ->add('hasKid')
            ->add('canQuarantine')
            ->add('houseSize')
            ->add('houseType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FA::class,
        ]);
    }
}
