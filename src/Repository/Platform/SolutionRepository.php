<?php

declare(strict_types=1);

namespace App\Repository\Platform;

use App\Entity\Platform\Exercise;
use App\Entity\Platform\Solution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solution::class);
    }
}
