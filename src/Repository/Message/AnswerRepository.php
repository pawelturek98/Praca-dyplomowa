<?php

declare(strict_types=1);

namespace App\Repository\Message;

use App\Entity\Message\Answer;
use App\Entity\Message\Message;
use App\Service\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    public function findAllPaginatedForMessage(Paginator $paginator, Message $message): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.parent = :parentMessage')
            ->setParameter('parentMessage', $message->getId(), 'uuid')
            ->setFirstResult($paginator->offset)
            ->setMaxResults($paginator->pageLimit)
            ->orderBy('a.sentAt', 'ASC')
            ->getQuery()
            ->execute();
    }
}
