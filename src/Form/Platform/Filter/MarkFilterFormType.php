<?php

declare(strict_types=1);

namespace App\Form\Platform\Filter;

use App\Dictionary\Platform\StatusDictionary;
use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\Platform\Course;
use App\Entity\UserManagement\User;
use App\Filter\CourseStudent\Filters\CourseFilter;
use App\Filter\CourseStudent\Filters\MarkedStatusFilter;
use App\Filter\CourseStudent\Filters\StatusFilter;
use App\Filter\CourseStudent\Filters\StudentFilter;
use App\Repository\Platform\CourseRepository;
use App\Repository\UserManagement\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class MarkFilterFormType extends AbstractType
{
    public function __construct(
        private readonly CourseRepository $courseRepository,
        private readonly UserRepository $userRepository,
        private readonly Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(CourseFilter::NAME, EntityType::class, [
                'required' => false,
                'class' => Course::class,
                'query_builder' => $this->courseRepository->getAllForTeacherCoursesQueryBuilder(
                    $this->security->getUser()
                ),
                'label' => 'app.filter.course',
                'choice_label' => function(Course $course): string {
                    return $course->getName();
                },
                'placeholder' => 'app.form.placeholder',
                'attr' => [
                    'class' => 'use-select2'
                ],
            ])
            ->add(StudentFilter::NAME, EntityType::class, [
                'required' => false,
                'class' => User::class,
                'query_builder' => $this->userRepository->getByTypeQueryBuilder(UserDictionary::ROLE_STUDENT),
                'label' => 'app.filter.student',
                'choice_label' => function(User $user): string {
                    return $user->getFullName();
                },
                'placeholder' => 'app.form.placeholder',
                'attr' => [
                    'class' => 'use-select2'
                ],
            ])
            ->add(MarkedStatusFilter::NAME, ChoiceType::class, [
                'required' => false,
                'placeholder' => 'app.form.placeholder',
                'label' => 'app.filter.status.label',
                'choices' => StatusDictionary::AVAILABLE_MARK_STATUSES,
                'choice_label' => function(string $label): string {
                    return sprintf('app.filter.status.%s', $label);
                },
                'attr' => [
                    'class' => 'use-select2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'name' => 'filter'
        ]);
    }
}
