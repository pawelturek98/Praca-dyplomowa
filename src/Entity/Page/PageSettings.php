<?php

declare(strict_types=1);

namespace App\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
class PageSettings
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'string')]
    private string $key;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $value = null;

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;
        return $this;
    }
}