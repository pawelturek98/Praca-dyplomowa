<?php

declare(strict_types=1);

namespace App\Service\Uploader\LocalFileUploader;

use App\Service\Uploader\AbstractUploader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class LocalFileUploaderStrategy extends AbstractUploader
{
    public function upload(): string
    {
        try {
            $this->getFile()->move($this->targetDirectory);
        } catch (FileException) {
        }

        return $this->getFilename();
    }
}
