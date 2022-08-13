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
    private ?string $falenameCmall = null;

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

    public function getFalenameCmall(): ?string
    {
        return $this->falenameCmall;
    }

    public function setFalenameCmall(string $falenameCmall): self
    {
        $this->falenameCmall = $falenameCmall;

        return $this;
    }
}
