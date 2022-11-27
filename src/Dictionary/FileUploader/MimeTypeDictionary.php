<?php

declare(strict_types=1);

namespace App\Dictionary\FileUploader;

class MimeTypeDictionary
{
    public const POSSIBLE_MIME_TYPES = [
        'pdf' => 'application/pdf',
        'xml' => 'application/xmp'
    ];
}
