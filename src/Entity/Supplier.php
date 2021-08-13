<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 */
class Supplier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supplier_ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supplier_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supplier_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supplier_adress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $supplier_phone;

    /**
     * @ORM\ManyToMany(targetEntity=Component::class, mappedBy="supplier")
     */
    private $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplierRef(): ?string
    {
        return $this->supplier_ref;
    }

    public function setSupplierRef(string $supplier_ref): self
    {
        $this->supplier_ref = $supplier_ref;

        return $this;
    }

    public function getSupplierName(): ?string
    {
        return $this->supplier_name;
    }

    public function setSupplierName(string $supplier_name): self
    {
        $this->supplier_name = $supplier_name;

        return $this;
    }

    public function getSupplierEmail(): ?string
    {
        return $this->supplier_email;
    }

    public function setSupplierEmail(string $supplier_email): self
    {
        $this->supplier_email = $supplier_email;

        return $this;
    }

    public function getSupplierAdress(): ?string
    {
        return $this->supplier_adress;
    }

    public function setSupplierAdress(string $supplier_adress): self
    {
        $this->supplier_adress = $supplier_adress;

        return $this;
    }

    public function getSupplierPhone(): ?string
    {
        return $this->supplier_phone;
    }

    public function setSupplierPhone(string $supplier_phone): self
    {
        $this->supplier_phone = $supplier_phone;

        return $this;
    }

    /**
     * @return Collection|Component[]
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Component $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components[] = $component;
            $component->addSupplier($this);
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        if ($this->components->removeElement($component)) {
            $component->removeSupplier($this);
        }

        return $this;
    }
}
