<?php

declare(strict_types=1);

namespace App\Form\Platform\Filter;

use App\Dictionary\Platform\StatusDictionary;
use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\UserManagement\User;
use App\Filter\CourseStudent\Filters\CloseDateFilter;
use App\Filter\CourseStudent\Filters\StartDateFilter;
use App\Filter\CourseStudent\Filters\StatusFilter;
use App\Filter\CourseStudent\Filters\TeacherFilter;
use App\Repository\UserManagement\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseStudentFilterFormType extends AbstractType
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(TeacherFilter::NAME, EntityType::class, [
                'class' => User::class,
                'query_builder' => $this->userRepository->getByTypeQueryBuilder(UserDictionary::ROLE_TEACHER),
                'label' => 'app.filter.teacher',
                'choice_label' => function(User $user): string {
                    return $user->getFullName();
                },
                'placeholder' => 'app.form.placeholder',
                'attr' => [
                    'class' => 'use-select2'
                ],
                'required' => false,
            ])
            ->add(StatusFilter::NAME, ChoiceType::class, [
                'label' => 'app.filter.status.label',
                'choices' => StatusDictionary::AVAILABLE_STATUSES_TRANSLATED,
                'placeholder' => 'app.form.placeholder',
                'required' => false,
            ])
            ->add(StartDateFilter::NAME, DateType::class, [
                'label' => 'app.filter.start_date',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add(CloseDateFilter::NAME, DateType::class, [
                'label' => 'app.filter.close_date',
                'widget' => 'single_text',
                'required' => false,
            ])
        ;
    }
}
