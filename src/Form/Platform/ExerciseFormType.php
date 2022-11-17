<?php

declare(strict_types=1);

namespace App\Form\Platform;

use App\Dictionary\Platform\StatusDictionary;
use App\Entity\Platform\Exercise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exerciseName', TextType::class, [
                'label' => 'app.course.exercise.form.name'
            ])
            ->add('exerciseContent', TextareaType::class, [
                'label' => 'app.course.exercise.form.description'
            ])
            ->add('closeDate', DateType::class, [
                'label' => 'app.course.exercise.form.close_date'
            ])
            ->add('state', ChoiceType::class, [
                'label' => 'app.course.exercise.form.state',
                'choices' => StatusDictionary::AVAILABLE_STATUSES,
                'choice_label' => function(string $value): string {
                    return sprintf('app.dictionary.status.%s', $value);
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class
        ]);
    }
}
