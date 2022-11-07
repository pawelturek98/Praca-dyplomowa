<?php

declare(strict_types=1);

namespace App\Entity\Platform;

use App\Entity\Dictionary\MarksDictionary;
use App\Entity\UserManagement\User;
use App\Repository\Platform\CourseStudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: CourseStudentRepository::class)]
class CourseStudent
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\ManyToOne(targetEntity: Course::class)]
    private Course $course;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $student;

    #[ORM\ManyToOne(targetEntity: MarksDictionary::class)]
    private MarksDictionary $marksDictionary;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isPassed = false;

    public function __construct()
    {
        $this->id = UuidV4::v4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
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

    public function getStudent(): User
    {
        return $this->student;
    }

    public function setStudent(User $student): self
    {
        $this->student = $student;
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

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function isPassed(): bool
    {
        return $this->isPassed;
    }

    public function setIsPassed(bool $isPassed): self
    {
        $this->isPassed = $isPassed;
        return $this;
    }
}
