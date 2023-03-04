<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use Doctrine\ORM\QueryBuilder;

class CloseDateFilter implements CourseStudentFilterInterface
{
    public const NAME = 'closeDate';

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
            ->andWhere('csc.closeDate = :closeDate')
            ->setParameter('closeDate', $data[self::NAME]);
    }
}
