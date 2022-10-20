<?php

declare(strict_types=1);

namespace App\Entity\Forum;

use App\Entity\UserManagement\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
class ForumPost
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $author;

    #[ORM\ManyToOne(targetEntity: Forum::class)]
    private Forum $forum;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTime $updatedAt;

    public function getId(): UuidV4
    {
        return $this->id;
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

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getForum(): Forum
    {
        return $this->forum;
    }

    public function setForum(Forum $forum): self
    {
        $this->forum = $forum;
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
}