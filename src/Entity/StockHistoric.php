<?php

namespace App\Entity;

use App\Repository\StockHistoricRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockHistoricRepository::class)
 */
class StockHistoric
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="stockHistorics")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="stockHistorics")
     * @ORM\JoinColumn(nullable=false)
     */
    private Products $productId;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private int $stock;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUserId(): User
    {
        return $this->userId;
    }

    /**
     * @param User $userId
     */
    public function setUserId(User $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return Products
     */
    public function getProductId(): Products
    {
        return $this->productId;
    }

    /**
     * @param Products $productId
     */
    public function setProductId(Products $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }
}
