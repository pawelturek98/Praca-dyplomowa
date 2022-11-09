<?php

declare(strict_types=1);

namespace App\Form\Platform;

use App\Dictionary\Platform\StatusDictionary;
use App\Entity\Platform\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app.course.form.name',
            ])
            ->add('description', TextType::class, [
                'label' => 'app.course.form.description',
            ])
            ->add('start_date', DateType::class, [
                'label' => 'app.course.form.start_date',
            ])
            ->add('close_date', DateType::class, [
                'label' => 'app.course.form.close_date'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => StatusDictionary::AVAILABLE_STATUSES,
                'choice_label' => function(string $value): string {
                    return sprintf('app.dictionary.status.%s', $value);
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
