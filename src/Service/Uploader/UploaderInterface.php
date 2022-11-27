<?php

declare(strict_types=1);

namespace App\Service\Uploader;

interface UploaderInterface
{
    public function upload(): string;
}
