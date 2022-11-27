<?php

declare(strict_types=1);

namespace App\Entity\Platform;

use App\Entity\UserManagement\User;
use App\Repository\Platform\CourseRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $startDate;

    #[ORM\Column(type: 'datetime')]
    private DateTime $closeDate;

    #[ORM\Column(type: 'string')]
    private string $status;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private UserInterface $leadingTeacher;

    public function __construct()
    {
        $this->id = UuidV4::v4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getLeadingTeacher(): UserInterface
    {
        return $this->leadingTeacher;
    }

    public function setLeadingTeacher(UserInterface $leadingTeacher): self
    {
        $this->leadingTeacher = $leadingTeacher;
        return $this;
    }
}
