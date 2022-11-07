<?php

declare(strict_types=1);

namespace App\Filter\Course\Filters;

use Doctrine\ORM\QueryBuilder;

class StatusFilter implements CourseFilterInterface
{
    public const NAME = 'courseStatus';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $queryBuilder->andWhere(
            'c.status = :courseStatus'
        )
            ->setParameter('courseStatus', $data[self::NAME]);
    }
}
