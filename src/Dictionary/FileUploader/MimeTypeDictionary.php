<?php

declare(strict_types=1);

namespace App\Dictionary\FileUploader;

final class MimeTypeDictionary
{
    public const POSSIBLE_MIME_TYPES = [
        'pdf' => 'application/pdf',
        'xml' => 'application/xml',
        'zip' => 'application/zip',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
    ];
}
