<?php

declare(strict_types=1);

namespace App\Filter\UserManagement\Filters;

use Doctrine\ORM\QueryBuilder;

class UserTypeFilter implements UserFilterInterface
{
    public const NAME = 'userType';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        // TODO: Implement modifyQueryBuilder() method.
    }
}
