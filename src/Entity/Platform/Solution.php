<?php

declare(strict_types=1);

namespace App\Entity\Platform;

use App\Entity\Dictionary\MarksDictionary;
use App\Entity\UserManagement\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
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
    private MarksDictionary $marksDictionary;

    #[ORM\Column(type: 'datetime')]
    private DateTime $disposedAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isSaved;

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getStudent(): User
    {
        return $this->student;
    }

    public function setStudent(User $student): self
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

    public function getMarksDictionary(): MarksDictionary
    {
        return $this->marksDictionary;
    }

    public function setMarksDictionary(MarksDictionary $marksDictionary): self
    {
        $this->marksDictionary = $marksDictionary;
        return $this;
    }

    public function getDisposedAt(): DateTime
    {
        return $this->disposedAt;
    }

    public function setDisposedAt(DateTime $disposedAt): self
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