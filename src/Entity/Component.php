<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComponentRepository::class)
 */
class Component
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $component_ref;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $component_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $component_cost;

    /**
     * @ORM\ManyToMany(targetEntity=Task::class, inversedBy="components")
     */
    private $task;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, inversedBy="components")
     */
    private $supplier;

    public function __construct()
    {
        $this->task = new ArrayCollection();
        $this->supplier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComponentRef(): ?string
    {
        return $this->component_ref;
    }

    public function setComponentRef(string $component_ref): self
    {
        $this->component_ref = $component_ref;

        return $this;
    }

    public function getComponentName(): ?string
    {
        return $this->component_name;
    }

    public function setComponentName(string $component_name): self
    {
        $this->component_name = $component_name;

        return $this;
    }

    public function getComponentCost(): ?int
    {
        return $this->component_cost;
    }

    public function setComponentCost(int $component_cost): self
    {
        $this->component_cost = $component_cost;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTask(): Collection
    {
        return $this->task;
    }

    public function addTask(Task $task): self
    {
        if (!$this->task->contains($task)) {
            $this->task[] = $task;
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        $this->task->removeElement($task);

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSupplier(): Collection
    {
        return $this->supplier;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->supplier->contains($supplier)) {
            $this->supplier[] = $supplier;
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        $this->supplier->removeElement($supplier);

        return $this;
    }
}
