<?php

declare(strict_types=1);

namespace App\Filter;

use App\Service\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

interface FilterGeneratorInterface
{
    public function findResults(): array;
    public function countResults(): int;
    public function setData(?array $data): self;
    public function setPaginator(?Paginator $paginator): self;
    public function getModifiedQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder;
}
