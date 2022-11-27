<?php

declare(strict_types=1);

namespace App\Filter\UserManagement;

use App\Filter\FilterGeneratorInterface;
use App\Filter\UserManagement\Filters\UserFilterInterface;
use App\Repository\UserManagement\UserRepository;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

class UserFilterGenerator implements FilterGeneratorInterface
{
    private ?array $data = [];
    private ?Paginator $paginator = null;

    public function __construct(
        private readonly iterable $userFilter,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function findResults(): array
    {
        $qb = $this->userRepository->getFindAllQueryBuilder();
        $qb = $this->getModifiedQueryBuilder($qb);

        if (null !== $this->paginator) {
            $qb->setMaxResults($this->paginator->pageLimit);
            $qb->setFirstResult($this->paginator->offset);
        }

        return $this->userRepository->findByQueryBuilder($qb);
    }

    public function countResults(): int
    {
        $qb = $this->userRepository->getCountResultsQueryBuilder();

        return $this->userRepository->countResultsByQueryBuilder(
            $this->getModifiedQueryBuilder($qb)
        );
    }

    public function setData(?array $data): FilterGeneratorInterface
    {
        $this->data = $data;

        return $this;
    }

    public function setPaginator(?Paginator $paginator): FilterGeneratorInterface
    {
        $this->paginator = $paginator;

        return $this;
    }

    public function getModifiedQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        foreach ($this->userFilter as $filter) {
            /** @var UserFilterInterface $filter */
            if ($filter->support($this->data)) {
                $filter->modifyQueryBuilder($queryBuilder, $this->data);
            }
        }

        return $queryBuilder;
    }
}
