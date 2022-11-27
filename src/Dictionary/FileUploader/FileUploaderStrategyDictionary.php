<?php

declare(strict_types=1);

namespace App\Dictionary\FileUploader;

final class FileUploaderStrategyDictionary
{
    public const STRATEGY_LOCAL = 'local';
    public const STRATEGY_AWS_S3 = 's3';

    public const AVAILABLE_STRATEGIES = [
        self::STRATEGY_LOCAL,
        self::STRATEGY_AWS_S3
    ];
}
