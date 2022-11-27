<?php

declare(strict_types=1);

namespace App\Filter\Course\Filters;

use Doctrine\ORM\QueryBuilder;

class StartDateFilter implements CourseFilterInterface
{
    public const NAME = 'startDate';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $queryBuilder
            ->andWhere('c.startDate = :startDate')
            ->setParameter('startDate', $data[self::NAME]);
    }
}
