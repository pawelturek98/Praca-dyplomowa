<?php

declare(strict_types=1);

namespace App\Entity\Message;

use App\Entity\UserManagement\User;
use App\Repository\Message\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\ManyToOne(targetEntity: Message::class, inversedBy: 'answers')]
    private Message $parent;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $sender;

    #[ORM\Column(type: 'datetime')]
    private DateTime $sentAt;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->sentAt = new DateTime('now');
    }

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

    public function getParent(): Message
    {
        return $this->parent;
    }

    public function setParent(Message $parent): self
    {
        $this->parent = $parent;
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
}
