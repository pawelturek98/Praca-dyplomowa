<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use Doctrine\ORM\QueryBuilder;

class StudentFilter implements CourseStudentFilterInterface
{
    public const NAME = 'student';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $queryBuilder
            ->andWhere('cs.student = :student')
            ->setParameter('student', $data[self::NAME]);
    }
}
