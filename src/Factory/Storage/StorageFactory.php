<?php

declare(strict_types=1);

namespace App\Factory\Storage;

use App\Dictionary\FileUploader\MimeTypeDictionary;
use App\Entity\Files\Storage;
use Symfony\Component\Security\Core\User\UserInterface;

class StorageFactory
{
    public function create(string $filename, UserInterface $createdBy): Storage
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        return (new Storage())
            ->setName($filename)
            ->setType(MimeTypeDictionary::POSSIBLE_MIME_TYPES[$extension])
            ->setCreatedBy($createdBy)
            ->setExtension($extension)
            ->setHash(md5($filename));
    }
}
