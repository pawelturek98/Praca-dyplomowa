<?php

declare(strict_types=1);

namespace App\Entity\Files;

use App\Entity\Platform\Course;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
class CourseAttachment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\ManyToOne(targetEntity: Storage::class)]
    private Storage $storage;

    #[ORM\ManyToOne(targetEntity: Course::class)]
    private Course $course;

    public function __construct()
    {
        $this->id = UuidV4::v4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getStorage(): Storage
    {
        return $this->storage;
    }

    public function setStorage(Storage $storage): self
    {
        $this->storage = $storage;
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
