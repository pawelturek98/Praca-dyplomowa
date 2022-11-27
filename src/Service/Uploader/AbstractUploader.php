<?php

declare(strict_types=1);

namespace App\Service\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class AbstractUploader implements UploaderInterface
{
    protected UploadedFile $file;

    protected string $targetDirectory;

    public function __construct(
        protected SluggerInterface $slugger
    ) {
    }

    public function upload(): string
    {
        return '';
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function setTargetDirectory(string $targetDirectory): self
    {
        $this->targetDirectory = $targetDirectory;
        return $this;
    }

    protected function getFilename(): string
    {
        $pathInfo = pathinfo($this->getFile()->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($pathInfo);

        return sprintf(
            '%s-%s.%s',
            $safeFilename,
            uniqid(),
            $this->getFile()->guessExtension()
        );
    }
}
