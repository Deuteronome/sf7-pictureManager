<?php

namespace App\Entity;

use App\Repository\RegistrationCodesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationCodesRepository::class)]
class RegistrationCodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $code = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'registrationCodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $created_by = null;

    #[ORM\Column(options: ['default' => 'TRUE'])]
    private ?bool $is_available = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Users $used_by = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->is_available = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?Users
    {
        return $this->created_by;
    }

    public function setCreatedBy(?Users $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->is_available;
    }

    public function setIsAvailable(bool $is_available): static
    {
        $this->is_available = $is_available;

        return $this;
    }

    public function getUsedBy(): ?Users
    {
        return $this->used_by;
    }

    public function setUsedBy(?Users $used_by): static
    {
        $this->used_by = $used_by;

        return $this;
    }
}
