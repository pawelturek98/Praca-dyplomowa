<?php

declare(strict_types=1);

namespace App\Counter\Message;

use App\Repository\Message\MessageRepository;
use Symfony\Component\Security\Core\Security;

class UserNewMessagesCounter
{
    public function __construct(
        private readonly MessageRepository $messageRepository,
        private readonly Security $security,
    ) {
    }

    public function count(): int
    {
        return $this->messageRepository->count(['receiver' => $this->security->getUser(), 'isSeen' => false]);
    }
}
