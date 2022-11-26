<?php

declare(strict_types=1);

namespace App\Form\Page;

use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\Page\SiteSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteSettingsFormType extends AbstractType
{
    private const YES_NO_CHOICE = [
        'app.yes' => true,
        'app.no' => false,
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siteName', TextType::class, [
                'label' => 'app.settings.site_name',
            ])
            ->add('siteDescription', TextareaType::class, [
                'label' => 'app.settings.site_description',
            ])
            ->add('enableRegistration', ChoiceType::class, [
                'choices' => self::YES_NO_CHOICE,
                'label' => 'app.settings.enable_registration',
            ])
            ->add('defaultRegistrationRole', ChoiceType::class, [
                'choices' => UserDictionary::POSSIBLE_ROLES_TRANSLATED,
                'label' => 'app.settings.default_registration_role',
            ])
            ->add('enableForum', ChoiceType::class, [
                'choices' => self::YES_NO_CHOICE,
                'label' => 'app.settings.enable_forum',
            ])
            ->add('enableMessages', ChoiceType::class, [
                'choices' => self::YES_NO_CHOICE,
                'label' => 'app.settings.enable_messages',
            ])
            ->add('sendNotifications', ChoiceType::class, [
                'choices' => self::YES_NO_CHOICE,
                'label' => 'app.settings.enable_notifications',
            ])
            ->add('favicon', FileType::class, [
                'label' => 'app.settings.favicon',
                'mapped' => false,
                'required' => false,
            ])
            ->add('siteKeywords', TextType::class, [
                'label' => 'app.settings.site_keywords',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteSettings::class
        ]);
    }
}