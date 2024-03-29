<?php

declare(strict_types=1);

namespace App\Form\Storage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Contracts\Translation\TranslatorInterface;

class StorageFormType extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10240k', // 10 Mb
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/zip',
                        ],
                        'mimeTypesMessage' => $this->translator->trans('app.file.validation.message')
                    ])
                ]
            ]);
    }
}
