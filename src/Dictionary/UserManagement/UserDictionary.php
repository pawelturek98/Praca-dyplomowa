<?php

declare(strict_types=1);

namespace App\Dictionary\UserManagement;

final class UserDictionary
{
    public const ROLE_ADMINISTRATOR = 'ROLE_ADMINISTRATOR';
    public const ROLE_TEACHER = 'ROLE_TEACHER';
    public const ROLE_STUDENT = 'ROLE_STUDENT';

    public const POSSIBLE_ROLES = [
        self::ROLE_ADMINISTRATOR => 'administrator',
        self::ROLE_TEACHER => 'teacher',
        self::ROLE_STUDENT => 'student'
    ];
}
