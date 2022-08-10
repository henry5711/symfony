<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    /**
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "El codigo no tiene 4 caracteres",
     *      maxMessage = "El codigo tiene mas de 10 caracteres"
     * )
     * @Assert\NotBlank
     * @Assert\Regex("/^[a-zA-Z0-9]+$/")
     */
    private ?string $code = null;

    #[ORM\Column(length: 70)]
     /**
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "El codigo no tiene 4 caracteres",
     * )
     * @Assert\NotBlank
     */
    
    private ?string $name = null;
    #[ORM\Column(length: 255)]

     /**
     * @Assert\NotBlank
     */
    private ?string $description = null;

    #[ORM\Column(length: 100)]
     /**
     * @Assert\NotBlank
     */
    private ?string $brand = null;

    #[ORM\Column]
     /**
     * @Assert\NotBlank
     *  @Assert\PositiveOrZero
     */
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

   
    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

}
