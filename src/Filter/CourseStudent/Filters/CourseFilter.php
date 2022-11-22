<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use Doctrine\ORM\QueryBuilder;

class CourseFilter implements CourseStudentFilterInterface
{
    public const NAME = 'course';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $queryBuilder
            ->andWhere('cs.course = :course')
            ->setParameter('course', $data[self::NAME], 'uuid');
    }
}
