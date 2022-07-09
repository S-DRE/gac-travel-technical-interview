<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $stock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="products")
     */
    private Categories $category;

    /**
     * @ORM\OneToMany(targetEntity=StockHistoric::class, mappedBy="productId")
     */
    private Collection $stockHistorics;

    public function __construct()
    {
        $this->stockHistorics = new ArrayCollection();
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

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Categories|null
     */
    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    /**
     * @param Categories|null $category
     */
    public function setCategory(?Categories $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Collection<int, StockHistoric>
     */
    public function getStockHistorics(): Collection
    {
        return $this->stockHistorics;
    }

    public function addStockHistoric(StockHistoric $stockHistoric): self
    {
        if (!$this->stockHistorics->contains($stockHistoric)) {
            $this->stockHistorics[] = $stockHistoric;
            $stockHistoric->setProductId($this);
        }

        return $this;
    }

    public function removeStockHistoric(StockHistoric $stockHistoric): self
    {
        if ($this->stockHistorics->removeElement($stockHistoric)) {
            // set the owning side to null (unless already changed)
            if ($stockHistoric->getProductId() === $this) {
                $stockHistoric->setProductId(null);
            }
        }

        return $this;
    }
}
