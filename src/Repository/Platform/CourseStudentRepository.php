<?php

declare(strict_types=1);

namespace App\Repository\Platform;

use App\Entity\Platform\Course;
use App\Entity\Platform\CourseStudent;
use App\Repository\FilterableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CourseStudentRepository extends ServiceEntityRepository implements FilterableRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseStudent::class);
    }

    public function getFindAllQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('cs')
            ->from(CourseStudent::class, 'cs');
    }

    public function findByQueryBuilder(QueryBuilder $queryBuilder): array
    {
        return $queryBuilder->getQuery()->execute();
    }

    public function getCountResultsQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('count(cs.id)')
            ->from(CourseStudent::class, 'cs');
    }

    public function countResultsByQueryBuilder(QueryBuilder $queryBuilder): int
    {
        try {
            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException|NoResultException) {
            return 0;
        }
    }
}
