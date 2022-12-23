<?php

namespace App\Entity;

use App\Repository\CouponsTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponsTypesRepository::class)]
class CouponsTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $code = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $discount = null;

    #[ORM\Column]
    private ?int $max_usage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $validity = null;

    #[ORM\Column]
    private ?bool $is_valid = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'couponsTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $coupons_types = null;

    #[ORM\OneToMany(mappedBy: 'coupons_types', targetEntity: self::class, orphanRemoval: true)]
    private Collection $couponsTypes;

    #[ORM\OneToMany(mappedBy: 'coupons', targetEntity: Orders::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->couponsTypes = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getMaxUsage(): ?int
    {
        return $this->max_usage;
    }

    public function setMaxUsage(int $max_usage): self
    {
        $this->max_usage = $max_usage;

        return $this;
    }

    public function getValidity(): ?\DateTimeInterface
    {
        return $this->validity;
    }

    public function setValidity(\DateTimeInterface $validity): self
    {
        $this->validity = $validity;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setIsValid(bool $is_valid): self
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCouponsTypes(): ?self
    {
        return $this->coupons_types;
    }

    public function setCouponsTypes(?self $coupons_types): self
    {
        $this->coupons_types = $coupons_types;

        return $this;
    }

    public function addCouponsType(self $couponsType): self
    {
        if (!$this->couponsTypes->contains($couponsType)) {
            $this->couponsTypes->add($couponsType);
            $couponsType->setCouponsTypes($this);
        }

        return $this;
    }

    public function removeCouponsType(self $couponsType): self
    {
        if ($this->couponsTypes->removeElement($couponsType)) {
            // set the owning side to null (unless already changed)
            if ($couponsType->getCouponsTypes() === $this) {
                $couponsType->setCouponsTypes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCoupons($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCoupons() === $this) {
                $order->setCoupons(null);
            }
        }

        return $this;
    }
}
