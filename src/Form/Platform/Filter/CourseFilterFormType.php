<?php

declare(strict_types=1);

namespace App\Form\Platform\Filter;

use App\Filter\CourseStudent\Filters\CloseDateFilter;
use App\Filter\CourseStudent\Filters\StartDateFilter;
use App\Filter\CourseStudent\Filters\StatusFilter;
use App\Filter\CourseStudent\Filters\TeacherFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(TeacherFilter::NAME, ChoiceType::class, [
            ])
            ->add(StatusFilter::NAME, ChoiceType::class, [

            ])
            ->add(StartDateFilter::NAME, DateType::class)
            ->add(CloseDateFilter::NAME, DateType::class)
        ;
    }
}
