<?php

namespace App\Form\UserManagement;

use App\Entity\UserManagement\Address;
use App\Resource\Address\CountryResource;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressFormType extends AbstractType
{
    public function __construct(
        private readonly CountryResource $countryResource
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'app.address.form.city',
            ])
            ->add('street', TextType::class, [
                'label' => 'app.address.form.street',
            ])
            ->add('streetNumber', TextType::class, [
                'label' => 'app.address.form.street_number',
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'app.address.form.postal_code',
                'attr' => [
                    'class' => 'postal-code'
                ]
            ])
            ->add('vatNumber', TextType::class, [
                'label' => 'app.address.form.vat_number',
            ])
            ->add('pesel', TextType::class, [
                'label' => 'app.address.form.pesel',
            ])
            ->add('district', TextType::class, [
                'label' => 'app.address.form.district',
            ])
            ->add('province', TextType::class, [
                'label' => 'app.address.form.province'
            ])
            ->add('countryCode', ChoiceType::class, [
                'label' => 'app.address.form.country',
                'choices' => $this->countryResource->getAllCountriesList(),
                'attr' => [
                    'class' => 'use-select2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
