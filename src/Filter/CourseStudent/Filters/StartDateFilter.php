<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use Doctrine\ORM\QueryBuilder;

class StartDateFilter implements CourseStudentFilterInterface
{
    public const NAME = 'startDate';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        if (!in_array('csc', $queryBuilder->getAllAliases())) {
            $queryBuilder->leftJoin('cs.course', 'csc');
        }

        $queryBuilder
            ->andWhere('csc.startDate = :startDate')
            ->setParameter('startDate', $data[self::NAME]);
    }
}
