<?php

declare(strict_types=1);

namespace App\Form\UserManagement;

use App\Dictionary\UserManagement\UserDictionary;
use App\Filter\UserManagement\Filters\EmailFilter;
use App\Filter\UserManagement\Filters\FullnameFilter;
use App\Filter\UserManagement\Filters\UserTypeFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(EmailFilter::NAME, EmailType::class, [
                'label' => 'app.user.filter.email',
                'mapped' => false,
            ])
            ->add(FullnameFilter::NAME, TextType::class, [
                'label' => 'app.user.filter.fullname',
                'mapped' => false,
            ])
            ->add(UserTypeFilter::NAME, ChoiceType::class, [
                'choices' => UserDictionary::POSSIBLE_ROLES_TRANSLATED,
                'label' => 'app.user.filter.type',
                'mapped' => false,
            ]);
    }
}
