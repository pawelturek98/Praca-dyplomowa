<?php

declare(strict_types=1);

namespace App\Filter\Course\Filters;

use Doctrine\ORM\QueryBuilder;

class TeacherFilter implements CourseFilterInterface
{
    public const NAME = 'courseTeacher';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $queryBuilder->andWhere('c.leadingTeacher = :courseTeacher')
            ->setParameter('courseTeacher', $data[self::NAME]);
    }
}
