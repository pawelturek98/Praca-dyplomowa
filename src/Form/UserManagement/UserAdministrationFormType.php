<?php

declare(strict_types=1);

namespace App\Form\UserManagement;

use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\UserManagement\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdministrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'app.security.email',
            ])
            ->add('username', TextType::class, [
                'label' => 'app.security.username',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'app.security.firstname',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'app.security.lastname',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'app.security.type',
                'choices' => UserDictionary::POSSIBLE_ROLES_TRANSLATED,
            ])
            ->add('address', AddressFormType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
