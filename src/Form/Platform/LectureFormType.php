<?php

declare(strict_types=1);

namespace App\Form\Platform;

use App\Dictionary\Platform\LectureTypeDictionary;
use App\Entity\Platform\Lecture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class LectureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'app.lecture.form.type',
                'choices' => LectureTypeDictionary::POSSIBLE_LECTURE_TYPES,
                'choice_label' => function(string $value): string {
                    return sprintf('app.lecture.type.%s', $value);
                }
            ])
            ->add('name', TextType::class, [
                'label' => 'app.lecture.form.name',
            ])
            ->add('contentText', TextareaType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'app.lecture.form.content',
            ])
            ->add('contentUrl', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'app.lecture.form.content',
            ])
            ->add('contentFile', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'app.lecture.form.content',
                'constraints' => [
                    new File([
                        'maxSize' => '10240k', // 10 Mb
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'app.file.validation.message'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lecture::class
        ]);
    }
}
