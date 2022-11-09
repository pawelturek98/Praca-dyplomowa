<?php

declare(strict_types=1);

namespace App\Filter\Course;

use App\Filter\Course\Filters\CourseFilterInterface;
use App\Filter\FilterGeneratorInterface;
use App\Repository\Platform\CourseRepository;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

class CourseFilterGenerator implements FilterGeneratorInterface
{
    private ?array $data = [];
    private ?Paginator $paginator = null;

    public function __construct(
        private readonly iterable $courseFilter,
        private readonly CourseRepository $courseRepository
    ) {
    }

    public function findResults(): array
    {
        $qb = $this->courseRepository->getFindAllQueryBuilder();

        if (!in_array('ct', $qb->getAllAliases())) {
            $qb->leftJoin('c.leadingTeacher', 'ct');
        }

        $qb->addSelect($qb->getAllAliases());
        $qb = $this->getModifiedQueryBuilder($qb);
//        dd($qb->getQuery()->getSQL());

        if (null !== $this->paginator) {
            $qb->setMaxResults($this->paginator->pageLimit);
            $qb->setFirstResult($this->paginator->offset);
        }

        $qb->orderBy('c.name', 'ASC');
        return $this->courseRepository->findByQueryBuilder($qb);
    }

    public function countResults(): int
    {
        $qb = $this->courseRepository->getCountResultsQueryBuilder();

        return $this->courseRepository->countResultsByQueryBuilder(
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
        foreach ($this->courseFilter as $filter) {
            /** @var CourseFilterInterface $filter */
            if ($filter->support($this->data)) {
                $filter->modifyQueryBuilder($queryBuilder, $this->data);
            }
        }

        return $queryBuilder;
    }

}
