<?php

namespace App\Entity;

use App\Enums\ProductColorEnum;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $product_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    /**
     * @var Collection<int, CatalogSection>
     */
    #[ORM\ManyToMany(targetEntity: CatalogSection::class, inversedBy: 'products')]
    private Collection $ParentSection;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    /**
     * @var Collection<int, ProductReview>
     */
    #[ORM\OneToMany(targetEntity: ProductReview::class, mappedBy: 'Product')]
    private Collection $productReviews;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 32)]
    private ?string $barcode = null;

    #[ORM\Column(nullable: true)]
    private ?float $Weight = null;

    #[ORM\Column(nullable: true)]
    private ?int $Volume = null;

    #[ORM\Column(nullable: true, enumType: ProductColorEnum::class)]
    private ?ProductColorEnum $Color = null;

    public function __construct()
    {
        $this->ParentSection = new ArrayCollection();
        $this->productReviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, CatalogSection>
     */
    public function getParentSection(): Collection
    {
        return $this->ParentSection;
    }

    public function addParentSection(CatalogSection $parentSection): static
    {
        if (!$this->ParentSection->contains($parentSection)) {
            $this->ParentSection->add($parentSection);
        }

        return $this;
    }

    public function removeParentSection(CatalogSection $parentSection): static
    {
        $this->ParentSection->removeElement($parentSection);

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, ProductReview>
     */
    public function getProductReviews(): Collection
    {
        return $this->productReviews;
    }

    public function addProductReview(ProductReview $productReview): static
    {
        if (!$this->productReviews->contains($productReview)) {
            $this->productReviews->add($productReview);
            $productReview->setProduct($this);
        }

        return $this;
    }

    public function removeProductReview(ProductReview $productReview): static
    {
        if ($this->productReviews->removeElement($productReview)) {
            // set the owning side to null (unless already changed)
            if ($productReview->getProduct() === $this) {
                $productReview->setProduct(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->Weight;
    }

    public function setWeight(?float $Weight): static
    {
        $this->Weight = $Weight;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->Volume;
    }

    public function setVolume(?int $Volume): static
    {
        $this->Volume = $Volume;

        return $this;
    }

    public function getColor(): ?ProductColorEnum
    {
        return $this->Color;
    }

    public function setColor(?ProductColorEnum $Color): static
    {
        $this->Color = $Color;

        return $this;
    }
}
