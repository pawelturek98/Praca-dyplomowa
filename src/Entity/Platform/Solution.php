<?php

declare(strict_types=1);

namespace App\Entity\Platform;

use App\Entity\Dictionary\MarksDictionary;
use App\Entity\UserManagement\User;
use App\Repository\Platform\SolutionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: SolutionRepository::class)]
class Solution
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['remove'])]
    private User $student;

    #[ORM\ManyToOne(targetEntity: Exercise::class, cascade: ['remove'])]
    private Exercise $exercise;

    #[ORM\ManyToOne(targetEntity: Exercise::class, cascade: ['remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?MarksDictionary $marksDictionary = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $disposedAt = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isSaved = false;

    public function __construct()
    {
        $this->id = UuidV4::v4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getStudent(): User
    {
        return $this->student;
    }

    public function setStudent(User|UserInterface $student): self
    {
        $this->student = $student;
        return $this;
    }

    public function getExercise(): Exercise
    {
        return $this->exercise;
    }

    public function setExercise(Exercise $exercise): self
    {
        $this->exercise = $exercise;
        return $this;
    }

    public function getMarksDictionary(): ?MarksDictionary
    {
        return $this->marksDictionary;
    }

    public function setMarksDictionary(?MarksDictionary $marksDictionary): self
    {
        $this->marksDictionary = $marksDictionary;
        return $this;
    }

    public function getDisposedAt(): ?DateTime
    {
        return $this->disposedAt;
    }

    public function setDisposedAt(?DateTime $disposedAt): self
    {
        $this->disposedAt = $disposedAt;
        return $this;
    }

    public function isSaved(): bool
    {
        return $this->isSaved;
    }

    public function setIsSaved(bool $isSaved): self
    {
        $this->isSaved = $isSaved;
        return $this;
    }
}
