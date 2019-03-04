<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups("product")
     */
    private $issn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Serializer\Groups("product")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Choice(choices={"new", "pending", "in review", "approved", "inactive", "deleted"}, message="Enter a valid status")
     * @Serializer\Groups("product")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Serializer\Groups("product")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Serializer\Groups("product")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @Serializer\Groups("product")
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="products")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="uuid")
     * @Serializer\MaxDepth(2)
     */
    private $customer;

    public function __construct()
    {
        $this->status = "new";
    }

    public function __toString()
    {
        return $this->issn;
    }

    public function getIssn(): ?int
    {
        return $this->issn;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
