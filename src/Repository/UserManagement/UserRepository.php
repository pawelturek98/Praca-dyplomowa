<?php

declare(strict_types=1);

namespace App\Repository\UserManagement;

use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\Platform\CourseStudent;
use App\Entity\UserManagement\User;
use App\Repository\FilterableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements FilterableRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getFindAllQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');
    }

    public function findByQueryBuilder(QueryBuilder $queryBuilder): array
    {
        return $queryBuilder->getQuery()->execute();
    }

    public function getCountResultsQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('count(u.id)')
            ->from(CourseStudent::class, 'u');
    }

    public function countResultsByQueryBuilder(QueryBuilder $queryBuilder): int
    {
        try {
            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException|NoResultException) {
            return 0;
        }
    }

    public function getStudentsQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.type = :userType')
            ->setParameter('userType', UserDictionary::ROLE_STUDENT);
    }

    public function getAllStudents(): array
    {
        return $this->getStudentsQueryBuilder()
            ->getQuery()
            ->execute();
    }
}
