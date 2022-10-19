<?php

declare(strict_types=1);

namespace App\Enum\UserManagement;

enum UserTypeEnum
{
    case USER_STUDENT;
    case USER_TEACHER;
    case USER_MODERATOR;
    case USER_ADMINISTRATOR;
}
