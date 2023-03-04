<?php

declare(strict_types=1);

namespace App\Resolver\Storage;

use App\Enum\Storage\FileTypeEnum;

class FilePathResolver
{
    public function resolve(FileTypeEnum $type): string
    {
        return match ($type) {
            FileTypeEnum::SolutionAttachment => 'uploaded/solution_attachment',
            FileTypeEnum::MessageAttachment => 'uploaded/message_attachment',
            FileTypeEnum::LectureAttachment => 'uploaded/lecture_attachment',
            FileTypeEnum::ProfileImage => 'uploaded/profile_image',
            FileTypeEnum::Other => 'uploaded/other',
        };
    }
}
