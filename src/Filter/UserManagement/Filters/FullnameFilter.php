<?php

declare(strict_types=1);

namespace App\Filter\UserManagement\Filters;

use App\Helper\PersonNameHelper;
use Doctrine\ORM\QueryBuilder;

class FullnameFilter implements UserFilterInterface
{
    public const NAME = 'fullname';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        [$firstname, $lastname] = PersonNameHelper::getPersonFullName($data[self::NAME]);

        $queryBuilder->andWhere(
            '(lower(u.firstname) LIKE :firstname or lower(u.lastname) LIKE :lastname) or
             (lower(u.firstname) LIKE :lastname or lower(u.lastname) LIKE :firstname)'
        )
            ->setParameter('firstname', sprintf('%%%s%%', strtolower($firstname)))
            ->setParameter('lastname', sprintf('%%%s%%', strtolower($lastname)));
    }
}
