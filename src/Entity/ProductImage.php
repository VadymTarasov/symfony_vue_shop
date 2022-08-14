<?php

namespace App\Entity;

use App\Repository\ProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
class ProductImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    private ?string $filenameBig = null;

    #[ORM\Column(length: 255)]
    private ?string $falenameMiddle = null;

    #[ORM\Column(length: 255)]
    private ?string $falenameSmall = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getFilenameBig(): ?string
    {
        return $this->filenameBig;
    }

    public function setFilenameBig(string $filenameBig): self
    {
        $this->filenameBig = $filenameBig;

        return $this;
    }

    public function getFalenameMiddle(): ?string
    {
        return $this->falenameMiddle;
    }

    public function setFalenameMiddle(string $falenameMiddle): self
    {
        $this->falenameMiddle = $falenameMiddle;

        return $this;
    }

    public function getFalenameSmall(): ?string
    {
        return $this->falenameSmall;
    }

    public function setFalenameSmall(string $falenameSmall): self
    {
        $this->falenameSmall = $falenameSmall;

        return $this;
    }
}
