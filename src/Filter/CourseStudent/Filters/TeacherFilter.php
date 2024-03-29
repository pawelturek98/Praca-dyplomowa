<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use App\Entity\UserManagement\User;
use Doctrine\ORM\QueryBuilder;

class TeacherFilter implements CourseStudentFilterInterface
{
    public const NAME = 'teacher';

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
            ->andWhere('csc.leadingTeacher = :teacher')
            ->setParameter('teacher', $data[self::NAME], 'uuid');
    }
}
