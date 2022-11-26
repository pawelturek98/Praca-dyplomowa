<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\Files\Storage;
use App\Repository\Page\SiteSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteSettingsRepository::class)]
class SiteSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', options: ['default' => 'Default site name'])]
    private string $siteName = 'Default site name';

    #[ORM\Column(type: 'text', options: ['default' => 'Default site description'])]
    private string $siteDescription = 'Default site description';

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $enableRegistration = true;

    #[ORM\Column(type: 'string', options: ['default' => UserDictionary::ROLE_STUDENT])]
    private string $defaultRegistrationRole = UserDictionary::ROLE_STUDENT;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $enableForum = true;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $enableMessages = true;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $sendNotifications = true;

    #[ORM\OneToOne(targetEntity: Storage::class, cascade: ['persist'])]
    private ?Storage $favicon = null;

    #[ORM\Column(type: 'string', nullable: true, options: ['default' => ''])]
    private ?string $siteKeywords = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function getSiteName(): string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): self
    {
        $this->siteName = $siteName;
        return $this;
    }

    public function getSiteDescription(): string
    {
        return $this->siteDescription;
    }

    public function setSiteDescription(string $siteDescription): self
    {
        $this->siteDescription = $siteDescription;
        return $this;
    }

    public function isEnableRegistration(): bool
    {
        return $this->enableRegistration;
    }

    public function setEnableRegistration(bool $enableRegistration): self
    {
        $this->enableRegistration = $enableRegistration;
        return $this;
    }

    public function getDefaultRegistrationRole(): string
    {
        return $this->defaultRegistrationRole;
    }

    public function setDefaultRegistrationRole(string $defaultRegistrationRole): self
    {
        $this->defaultRegistrationRole = $defaultRegistrationRole;
        return $this;
    }

    public function isEnableForum(): bool
    {
        return $this->enableForum;
    }

    public function setEnableForum(bool $enableForum): self
    {
        $this->enableForum = $enableForum;
        return $this;
    }

    public function isEnableMessages(): bool
    {
        return $this->enableMessages;
    }

    public function setEnableMessages(bool $enableMessages): self
    {
        $this->enableMessages = $enableMessages;
        return $this;
    }

    public function isSendNotifications(): bool
    {
        return $this->sendNotifications;
    }

    public function setSendNotifications(bool $sendNotifications): self
    {
        $this->sendNotifications = $sendNotifications;
        return $this;
    }

    public function getFavicon(): ?Storage
    {
        return $this->favicon;
    }

    public function setFavicon(?Storage $favicon): self
    {
        $this->favicon = $favicon;
        return $this;
    }

    public function getSiteKeywords(): ?string
    {
        return $this->siteKeywords;
    }

    public function setSiteKeywords(?string $siteKeywords): self
    {
        $this->siteKeywords = $siteKeywords;
        return $this;
    }
}
