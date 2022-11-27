<?php

declare(strict_types=1);

namespace App\Filter\Course\Filters;

use Doctrine\ORM\QueryBuilder;

class TeacherFilter implements CourseFilterInterface
{
    public const NAME = 'leadingTeacher';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        if (!in_array('ct', $queryBuilder->getAllAliases())) {
            $queryBuilder->leftJoin('c.leadingTeacher', 'ct');
        }

        $queryBuilder->andWhere('ct.id = :leadingTeacher')
            ->setParameter('leadingTeacher', $data[self::NAME], 'uuid');
    }
}
