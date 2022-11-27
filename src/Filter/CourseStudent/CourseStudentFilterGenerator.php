<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent;

use App\Dictionary\Platform\StatusDictionary;
use App\Filter\CourseStudent\Filters\CourseStudentFilterInterface;
use App\Filter\FilterGeneratorInterface;
use App\Repository\Platform\CourseStudentRepository;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

class CourseStudentFilterGenerator implements FilterGeneratorInterface
{
    private ?array $data = [];
    private ?Paginator $paginator = null;

    public function __construct(
        private readonly iterable $courseStudentFilter,
        private readonly CourseStudentRepository $courseStudentRepository,
    ) {
    }

    public function findResults(): array
    {
        $qb = $this->courseStudentRepository->getFindAllQueryBuilder();
        if (!in_array('csc', $qb->getAllAliases())) {
            $qb->leftJoin('cs.course', 'csc');
            $qb->andWhere('csc.status <> :statusDeleted')
                ->setParameter('statusDeleted', StatusDictionary::STATUS_DELETED);
        }

        if (!in_array('css', $qb->getAllAliases())) {
            $qb->leftJoin('cs.student', 'css');
        }

        $qb->addSelect(['css', 'csc']);
        $qb = $this->getModifiedQueryBuilder($qb);

        if (null !== $this->paginator) {
            $qb->setMaxResults($this->paginator->pageLimit);
            $qb->setFirstResult($this->paginator->offset);
        }

        $qb->orderBy('csc.name', 'DESC');

        return $this->courseStudentRepository->findByQueryBuilder($qb);
    }

    public function countResults(): int
    {
        $qb = $this->courseStudentRepository->getCountResultsQueryBuilder();

        if (!in_array('csc', $qb->getAllAliases())) {
            $qb->leftJoin('cs.course', 'csc');
            $qb->andWhere('csc.status <> :statusDeleted')
                ->setParameter('statusDeleted', StatusDictionary::STATUS_DELETED);
        }

        return $this->courseStudentRepository->countResultsByQueryBuilder(
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
        foreach ($this->courseStudentFilter as $filter) {
            /** @var CourseStudentFilterInterface $filter */
            if ($filter->support($this->data)) {
                $filter->modifyQueryBuilder($queryBuilder, $this->data);
            }
        }

        return $queryBuilder;
    }
}
