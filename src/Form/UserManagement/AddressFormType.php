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
                'required' => false,
            ])
            ->add('street', TextType::class, [
                'label' => 'app.address.form.street',
                'required' => false,
            ])
            ->add('streetNumber', TextType::class, [
                'label' => 'app.address.form.street_number',
                'required' => false,
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'app.address.form.postal_code',
                'required' => false,
                'attr' => [
                    'class' => 'postal-code'
                ]
            ])
            ->add('vatNumber', TextType::class, [
                'label' => 'app.address.form.vat_number',
                'required' => false,
            ])
            ->add('pesel', TextType::class, [
                'label' => 'app.address.form.pesel',
                'required' => false,
            ])
            ->add('district', TextType::class, [
                'label' => 'app.address.form.district',
                'required' => false,
            ])
            ->add('province', TextType::class, [
                'label' => 'app.address.form.province',
                'required' => false,
            ])
            ->add('countryCode', ChoiceType::class, [
                'label' => 'app.address.form.country',
                'choices' => $this->countryResource->getAllCountriesList(),
                'required' => false,
                'attr' => [
                    'class' => 'use-select2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'csrf_protection' => false,
        ]);
    }
}
