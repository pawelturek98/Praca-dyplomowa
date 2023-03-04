<?php

declare(strict_types=1);

namespace App\Enum\Storage;

enum FileTypeEnum
{
    case SolutionAttachment;
    case MessageAttachment;
    case LectureAttachment;
    case ProfileImage;
    case Other;
}
