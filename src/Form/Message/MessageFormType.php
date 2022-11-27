<?php

declare(strict_types=1);

namespace App\Form\Message;

use App\Entity\Message\Message;
use App\Entity\UserManagement\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'app.messages.title',
            ])
            ->add('receiver', EntityType::class, [
                'class' => User::class,
                'label' => 'app.messages.receiver',
                'attr' => [
                    'class' => 'use-select2'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'app.messages.content',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class
        ]);
    }
}
