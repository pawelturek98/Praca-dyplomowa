<?php

declare(strict_types=1);

namespace App\DTO\Platform;

use App\Entity\Platform\Course;
use DateTime;
use Symfony\Component\Uid\Uuid;

class ExerciseDTO
{
    private Uuid $id;
    private string $name;
    private DateTime $createdAt;
    private DateTime $closedAt;
    private ?DateTime $disposedAt = null;
    private bool $isDisposed = false;
    private ?string $mark = '';
    private Course $course;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getClosedAt(): DateTime
    {
        return $this->closedAt;
    }

    public function setClosedAt(DateTime $closedAt): self
    {
        $this->closedAt = $closedAt;
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

    public function isDisposed(): bool
    {
        return $this->isDisposed;
    }

    public function setDisposed(bool $isDisposed): self
    {
        $this->isDisposed = $isDisposed;
        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(?string $mark): self
    {
        $this->mark = $mark;
        return $this;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;
        return $this;
    }
}
