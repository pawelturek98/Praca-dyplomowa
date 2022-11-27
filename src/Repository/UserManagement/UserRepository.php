<?php

declare(strict_types=1);

namespace App\Repository\UserManagement;

use App\Dictionary\UserManagement\UserDictionary;
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
            ->from(User::class, 'u');
    }

    public function countResultsByQueryBuilder(QueryBuilder $queryBuilder): int
    {
        try {
            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException|NoResultException) {
            return 0;
        }
    }

    public function getByTypeQueryBuilder(string $type): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.type = :userType')
            ->setParameter('userType', $type);
    }

    public function getAllStudents(): array
    {
        return $this->getByTypeQueryBuilder(UserDictionary::ROLE_STUDENT)
            ->getQuery()
            ->execute();
    }
}
