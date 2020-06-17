<?php

namespace App\Form;

use App\Entity\Donation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class MakeDonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', MoneyType::class, [
                'divisor' => 1,
                'attr' => [
                    'placeholder' => 'Montant de la donation souhaité'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
