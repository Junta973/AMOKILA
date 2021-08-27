<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialRepository::class)
 */
class Material
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
    private $ref_material;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_material;

    /**
     * @Assert\Type("DateTime")
     * @ORM\Column(type="date")
     */
    private $date_validation_in;

    /**
     * @Assert\Type("DateTime")
     * @ORM\Column(type="date")
     */
    private $date_validation_out;

    /**
     * @ORM\Column(type="integer")
     */
    private $material_cost;

    /**
     * @ORM\ManyToMany(targetEntity=Task::class, mappedBy="material")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefMaterial(): ?string
    {
        return $this->ref_material;
    }

    public function setRefMaterial(string $ref_material): self
    {
        $this->ref_material = $ref_material;

        return $this;
    }

    public function getNameMaterial(): ?string
    {
        return $this->name_material;
    }

    public function setNameMaterial(string $name_material): self
    {
        $this->name_material = $name_material;

        return $this;
    }

    public function getDateValidationIn(): ?\DateTimeInterface
    {
        return $this->date_validation_in;
    }

    public function setDateValidationIn(\DateTimeInterface $date_validation_in): self
    {
        $this->date_validation_in = $date_validation_in;

        return $this;
    }

    public function getDateValidationOut(): ?\DateTimeInterface
    {
        return $this->date_validation_out;
    }

    public function setDateValidationOut(\DateTimeInterface $date_validation_out): self
    {
        $this->date_validation_out = $date_validation_out;

        return $this;
    }

    public function getMaterialCost(): ?int
    {
        return $this->material_cost;
    }

    public function setMaterialCost(int $material_cost): self
    {
        $this->material_cost = $material_cost;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->addMaterial($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            $task->removeMaterial($this);
        }

        return $this;
    }
}
