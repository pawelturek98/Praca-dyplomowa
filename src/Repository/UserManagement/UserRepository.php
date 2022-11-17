<?php

declare(strict_types=1);

namespace App\Repository\UserManagement;

use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\UserManagement\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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
