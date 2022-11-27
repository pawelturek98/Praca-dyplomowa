<?php

declare(strict_types=1);

namespace App\FormHandler\UserManagement;

use App\Entity\UserManagement\Address;
use App\Entity\UserManagement\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
class UserFormHandler
{
    private ?User $user = null;
    private ?Address $address = null;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function handleAddressForm(FormInterface $form): bool
    {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        $this->getUser()?->setAddress($this->getAddress());
        $this->entityManager->persist($this->getAddress());
        $this->entityManager->persist($this->getUser());
        $this->entityManager->flush();

        return true;
    }

    public function handleUserForm(FormInterface $form): bool
    {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        $this->entityManager->persist($this->getUser());
        $this->entityManager->flush();

        return true;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function getAddress(): ?Address
    {
        return $this->address;
    }
    public function setAddress(?Address $address): self
    {
        $this->address = $address;
        return $this;
    }
}
