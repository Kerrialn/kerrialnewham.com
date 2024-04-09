<?php

namespace App\Entity;

use App\Repository\EmailRepository;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EmailRepository::class)]
class Email
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable|CarbonImmutable|null $createdAt = null;

    public function __construct(
    )
    {
        $this->createdAt = new CarbonImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCreatedAt(): null|CarbonImmutable|DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(null|CarbonImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
