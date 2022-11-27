<?php

declare(strict_types=1);

namespace App\Filter\UserManagement\Filters;

use Doctrine\ORM\QueryBuilder;

class EmailFilter implements UserFilterInterface
{
    public const NAME = 'email';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $queryBuilder->andWhere('u.email = :email')
            ->setParameter('email', $data[self::NAME]);
    }
}
