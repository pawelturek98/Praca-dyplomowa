<?php

declare(strict_types=1);

namespace App\Repository\Files;

use App\Entity\Files\SolutionAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SolutionAttachmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolutionAttachment::class);
    }
}
