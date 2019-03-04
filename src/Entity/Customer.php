<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"customer"})
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Serializer\Groups({"customer"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Serializer\Groups({"customer"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     * @Serializer\Groups({"customer"})
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Choice(choices={"active","non-active","deleted"}, message="Enter a valid status")
     * @Serializer\Groups({"customer"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Serializer\Groups({"customer"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Serializer\Groups({"customer"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @Serializer\Groups({"customer"})
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="customer", orphanRemoval=true)
     * @ORM\JoinColumn(referencedColumnName="issn")
     * @Serializer\MaxDepth(3)
     */
    private $products;

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->uuid,
            $this->firstName,
            $this->lastName,
            $this->status,
            $this->dateOfBirth,
            $this->createdAt,
            $this->updatedAt,
            $this->deletedAt
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->uuid,
            $this->firstName,
            $this->lastName,
            $this->status,
            $this->dateOfBirth,
            $this->createdAt,
            $this->updatedAt,
            $this->deletedAt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function getUUid(): ?int
    {
        return $this->uuid;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCustomer($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCustomer() === $this) {
                $product->setCustomer(null);
            }
        }

        return $this;
    }
}
