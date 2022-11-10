<?php

declare(strict_types=1);

namespace App\Service\Uploader;

use App\Dictionary\FileUploader\FileUploaderStrategyDictionary;
use App\Service\Uploader\LocalFileUploader\LocalFileUploaderStrategy;

class Uploader extends AbstractUploader
{
    private string $strategy;

    public function upload(): string
    {
        switch ($this->getStrategy()) {
            default:
            case FileUploaderStrategyDictionary::STRATEGY_LOCAL:
                $uploader = new LocalFileUploaderStrategy($this->slugger);
                break;
        }

        return $uploader
            ->setFile($this->getFile())
            ->setTargetDirectory($this->getTargetDirectory())
            ->upload();
    }

    public function setStrategy(string $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }
}
