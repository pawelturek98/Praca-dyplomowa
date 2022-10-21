<?php

namespace App\Form\UserManagement;

use App\Entity\UserManagement\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city')
            ->add('street')
            ->add('streetNumber')
            ->add('postalCode')
            ->add('vatNumber')
            ->add('pesel')
            ->add('district')
            ->add('province')
            ->add('countryCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
