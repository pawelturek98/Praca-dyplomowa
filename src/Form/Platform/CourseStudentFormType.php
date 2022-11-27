<?php

declare(strict_types=1);

namespace App\Form\Platform;

use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\Platform\CourseStudent;
use App\Entity\UserManagement\User;
use App\Repository\UserManagement\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseStudentFormType extends AbstractType
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('student', EntityType::class, [
                'label' => 'app.course.student_list.student',
                'class' => User::class,
                'query_builder' => $this->userRepository->getByTypeQueryBuilder(UserDictionary::ROLE_STUDENT),
                'choice_label' => function (User $user): string {
                    return $user->getFullName();
                },
                'attr' => [
                    'class' => 'use-select2'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseStudent::class
        ]);
    }
}
