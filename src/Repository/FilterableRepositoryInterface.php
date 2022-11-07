<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;

interface FilterableRepositoryInterface
{
    public function getFindAllQueryBuilder(): QueryBuilder;
    public function findByQueryBuilder(QueryBuilder $queryBuilder): array;
    public function getCountResultsQueryBuilder(): QueryBuilder;
    public function countResultsByQueryBuilder(QueryBuilder $queryBuilder): int;
}
