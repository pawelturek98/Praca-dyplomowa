<?php

declare(strict_types=1);

namespace App\Dictionary\Platform;

final class LectureTypeDictionary
{
    public const VIDEO_TYPE = 'video';
    public const TEXT_TYPE = 'text';
    public const PDF_TYPE = 'pdf';

    public const POSSIBLE_LECTURE_TYPES = [
        self::VIDEO_TYPE,
        self::TEXT_TYPE,
        self::PDF_TYPE
    ];
}
