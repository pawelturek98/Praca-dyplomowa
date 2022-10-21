<?php

declare(strict_types=1);

namespace App\Entity\Platform;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
class Exercise
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'string')]
    private string $exerciseContent;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTime $updatedAt;

    #[ORM\Column(type: 'datetime')]
    private DateTime $closeDate;

    #[ORM\Column(type: 'string')]
    private string $state;

    #[ORM\ManyToOne(targetEntity: Course::class, cascade: ['persist'])]
    private Course $course;

    public function __construct()
    {
        $this->id = UuidV4::v4();
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getExerciseContent(): string
    {
        return $this->exerciseContent;
    }

    public function setExerciseContent(string $exerciseContent): self
    {
        $this->exerciseContent = $exerciseContent;
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

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getCloseDate(): DateTime
    {
        return $this->closeDate;
    }

    public function setCloseDate(DateTime $closeDate): self
    {
        $this->closeDate = $closeDate;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;
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
