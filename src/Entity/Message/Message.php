<?php

declare(strict_types=1);

namespace App\Entity\Message;

use App\Entity\UserManagement\User;
use App\Repository\Message\MessageRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $receiver;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $sender;

    #[ORM\Column(type: 'datetime')]
    private DateTime $sentAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $seenAt = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isSeen = false;

    public function __construct()
    {
        $this->sentAt = new DateTime('now');
        $this->id = new UuidV4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
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

    public function getReceiver(): User
    {
        return $this->receiver;
    }

    public function setReceiver(User $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function getSender(): User|UserInterface
    {
        return $this->sender;
    }

    public function setSender(User|UserInterface $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getSentAt(): DateTime
    {
        return $this->sentAt;
    }

    public function setSentAt(DateTime $sentAt): self
    {
        $this->sentAt = $sentAt;
        return $this;
    }

    public function getSeenAt(): ?DateTime
    {
        return $this->seenAt;
    }

    public function setSeenAt(?DateTime $seenAt): self
    {
        $this->seenAt = $seenAt;
        return $this;
    }

    public function isSeen(): bool
    {
        return $this->isSeen;
    }

    public function setIsSeen(bool $isSeen): self
    {
        $this->isSeen = $isSeen;
        return $this;
    }
}
