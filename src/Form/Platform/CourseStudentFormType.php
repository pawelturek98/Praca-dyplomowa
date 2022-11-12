<?php

declare(strict_types=1);

namespace App\Form\Platform;

use App\Entity\Platform\CourseStudent;
use App\Entity\UserManagement\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseStudentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('student', EntityType::class, [
                'label' => 'app.course.student_list.student',
                'class' => User::class,
                'choice_label' => function (User $user): string {
                    return $user->getFullName();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseStudent::class
        ]);
    }
}
