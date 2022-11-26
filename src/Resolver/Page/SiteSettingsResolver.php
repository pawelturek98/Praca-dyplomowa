<?php

declare(strict_types=1);

namespace App\Resolver\Page;

use App\Entity\Page\SiteSettings;
use App\Repository\Page\SiteSettingsRepository;
class SiteSettingsResolver
{
    public function __construct(
        private readonly SiteSettingsRepository $siteSettingsRepository
    ) {
    }

    public function resolve(): SiteSettings
    {
        if($this->siteSettingsRepository->find(1)) {
            return $this->siteSettingsRepository->find(1);
        }

        return new SiteSettings();
    }
}
