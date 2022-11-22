<?php

declare(strict_types=1);

namespace App\Form\Dictionary;

use App\Entity\Dictionary\MarksDictionary;
use App\Repository\Dictionary\MarksDictionaryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MarkFormType extends AbstractType
{
    public function __construct(
        private readonly MarksDictionaryRepository $marksDictionaryRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', EntityType::class, [
                'label' => 'app.course.exercise.solution_list.mark',
                'class' => MarksDictionary::class,
                'mapped' => false,
                'query_builder' => $this->marksDictionaryRepository->getFindAllQueryBuilder(),
                'choice_label' => function (MarksDictionary $marksDictionary): string {
                    return $marksDictionary->getName();
                },
                'attr' => [
                    'class' => 'use-select2'
                ]
            ]);
    }
}
