<?php

declare(strict_types=1);

namespace App\Repository\Dictionary;

use App\Entity\Dictionary\MarksDictionary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class MarksDictionaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarksDictionary::class);
    }

    public function getFindAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('m')->orderBy('m.position', 'DESC');
    }
}
