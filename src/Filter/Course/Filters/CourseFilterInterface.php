<?php

declare(strict_types=1);

namespace App\Filter\Course\Filters;

use Doctrine\ORM\QueryBuilder;

interface CourseFilterInterface
{
    public function support(array $data): bool;
    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void;
}
