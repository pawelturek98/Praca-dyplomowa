<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use Doctrine\ORM\QueryBuilder;

interface CourseStudentFilterInterface
{
    public function support(array $data): bool;
    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void;
}
