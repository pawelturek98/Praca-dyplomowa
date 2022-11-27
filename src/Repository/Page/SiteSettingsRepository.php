<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Entity\Page\SiteSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SiteSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteSettings::class);
    }

    public function findOnlyOneSetting(): ?SiteSettings
    {
        return $this->createQueryBuilder('s')
            ->getQuery()->execute()[0] ?? null;
    }
}
