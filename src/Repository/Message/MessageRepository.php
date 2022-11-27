<?php

declare(strict_types=1);

namespace App\Repository\Message;

use App\Entity\Message\Message;
use App\Service\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllPaginatedForUser(Paginator $paginator, UserInterface $user): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.receiver = :user')
            ->setParameter('user', $user->getId(), 'uuid')
            ->setFirstResult($paginator->offset)
            ->setMaxResults($paginator->pageLimit)
            ->orderBy('m.sentAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllPaginatedForSender(Paginator $paginator, UserInterface $user): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.sender = :user')
            ->setParameter('user', $user->getId(), 'uuid')
            ->setFirstResult($paginator->offset)
            ->setMaxResults($paginator->pageLimit)
            ->orderBy('m.sentAt', 'DESC')
            ->getQuery()
            ->execute();
    }
}
