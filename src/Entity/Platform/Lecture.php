<?php

declare(strict_types=1);

namespace App\Entity\Platform;

use App\Entity\Files\Storage;
use App\Repository\Platform\LectureRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;


#[ORM\Entity(repositoryClass: LectureRepository::class)]
class Lecture
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: True)]
    private UuidV4 $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'text')]
    private string $content = '';

    #[ORM\ManyToOne(targetEntity: Course::class, cascade: ['persist'])]
    private Course $course;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\OneToOne(targetEntity: Storage::class, cascade: ['remove', 'persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Storage $lectureFile = null;

    public function __construct()
    {
        $this->id = UuidV4::v4();
        $this->createdAt = new DateTime('now');
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getLectureFile(): ?Storage
    {
        return $this->lectureFile;
    }

    public function setLectureFile(?Storage $lectureFile): self
    {
        $this->lectureFile = $lectureFile;
        return $this;
    }
}
