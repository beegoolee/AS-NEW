<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carts')]
    private ?User $Owner = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $Products = null;

    #[ORM\Column]
    private ?bool $IsOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?User $Owner): static
    {
        $this->Owner = $Owner;

        return $this;
    }

    public function getProducts(): ?array
    {
        return $this->Products;
    }

    public function setProducts(?array $Products): static
    {
        $this->Products = $Products;

        return $this;
    }

    public function isOrder(): ?bool
    {
        return $this->IsOrder;
    }

    public function setIsOrder(bool $IsOrder): static
    {
        $this->IsOrder = $IsOrder;

        return $this;
    }
}
