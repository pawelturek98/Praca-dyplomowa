<?php

declare(strict_types=1);

namespace App\Entity\UserManagement;

use App\Repository\UserManagement\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $street = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $streetNumber = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $vatNumber = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $pesel = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $district = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $province = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $countryCode;

    public function __construct()
    {
        $this->id = UuidV4::v4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(?string $vatNumber): self
    {
        $this->vatNumber = $vatNumber;
        return $this;
    }

    public function getPesel(): ?int
    {
        return $this->pesel;
    }

    public function setPesel(?int $pesel): self
    {
        $this->pesel = $pesel;
        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): self
    {
        $this->district = $district;
        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;
        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }
}
