<?php

declare(strict_types=1);

namespace App\Dictionary\Main;

final class FlashTypeDictionary
{
    public const ERROR = 'error';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    
    public const POSSIBLE_FLASH_TYPES = [
        self::ERROR,
        self::SUCCESS,
        self::WARNING,
    ];
}
