<?php

declare(strict_types=1);

namespace App\Repository\Platform;

use App\Entity\Platform\Course;
use App\Repository\FilterableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class CourseRepository extends ServiceEntityRepository implements FilterableRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function getFindAllQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from(Course::class, 'c');
    }

    public function findByQueryBuilder(QueryBuilder $queryBuilder): array
    {
        return $queryBuilder->getQuery()->execute();
    }

    public function getCountResultsQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('count(c.id)')
            ->from(Course::class, 'c');
    }

    public function countResultsByQueryBuilder(QueryBuilder $queryBuilder): int
    {
        try {
            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException|NoResultException) {
            return 0;
        }
    }

    public function getAllForTeacherCoursesQueryBuilder(UserInterface $teacher): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->where('c.leadingTeacher = :leadingTeacher')
            ->setParameter('leadingTeacher', $teacher->getId(), 'uuid');
    }
}
