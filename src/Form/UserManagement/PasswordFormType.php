<?php

declare(strict_types=1);

namespace App\Form\UserManagement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class PasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'app.security.old_password',
                'mapped' => false,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'app.security.password',
                'mapped' => false,
            ])
            ->add('passwordRepeat', PasswordType::class, [
                'label' => 'app.security.repeat_password',
                'mapped' => false,
            ]);
    }
}
