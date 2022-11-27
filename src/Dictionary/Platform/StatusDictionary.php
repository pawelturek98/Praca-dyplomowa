<?php

declare(strict_types=1);

namespace App\Dictionary\Platform;

final class StatusDictionary
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_SUSPENDED = 'suspended';
    public const STATUS_DELETED = 'deleted';

    public const STATUS_MARKED = 'marked';
    public const STATUS_UNMARKED = 'unmarked';

    public const AVAILABLE_STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_SUSPENDED,
    ];

    public const AVAILABLE_STATUSES_TRANSLATED = [
        'app.dictionary.status.active' => self::STATUS_ACTIVE,
        'app.dictionary.status.inactive' => self::STATUS_INACTIVE,
        'app.dictionary.status.suspended' => self::STATUS_SUSPENDED,
        'app.dictionary.status.deleted' => self::STATUS_DELETED,
    ];

    public const AVAILABLE_MARK_STATUSES = [
        self::STATUS_MARKED,
        self::STATUS_UNMARKED,
    ];
}
