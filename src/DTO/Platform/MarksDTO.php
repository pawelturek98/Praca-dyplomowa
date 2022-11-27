<?php

declare(strict_types=1);

namespace App\DTO\Platform;

use Symfony\Component\Uid\Uuid;

class MarksDTO
{
    private Uuid $courseId;
    private Uuid $studentId;
    private string $courseName;
    private string $leadingTeacher;
    private string $student;
    private string $status;
    private float $componentMark;
    private ?int $mark;

    public function getCourseId(): Uuid
    {
        return $this->courseId;
    }

    public function setCourseId(Uuid $courseId): self
    {
        $this->courseId = $courseId;
        return $this;
    }

    public function getStudentId(): Uuid
    {
        return $this->studentId;
    }

    public function setStudentId(Uuid $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }

    public function getCourseName(): string
    {
        return $this->courseName;
    }

    public function setCourseName(string $courseName): self
    {
        $this->courseName = $courseName;
        return $this;
    }

    public function getLeadingTeacher(): string
    {
        return $this->leadingTeacher;
    }

    public function setLeadingTeacher(string $leadingTeacher): self
    {
        $this->leadingTeacher = $leadingTeacher;
        return $this;
    }

    public function getStudent(): string
    {
        return $this->student;
    }

    public function setStudent(string $student): self
    {
        $this->student = $student;
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

    public function getComponentMark(): float
    {
        return $this->componentMark;
    }

    public function setComponentMark(float $componentMark): self
    {
        $this->componentMark = $componentMark;
        return $this;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(?int $mark): self
    {
        $this->mark = $mark;
        return $this;
    }
}
