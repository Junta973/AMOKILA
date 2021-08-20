<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
    private $task_ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $task_name;

    /**
     * @ORM\Column(type="text")
     */
    private $task_description;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="float")
     */
    private $progress;

    /**
     * @ORM\Column(type="integer")
     */
    private $task_cost;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="tasks")
     */
    private $projet;

    /**
     * @ORM\ManyToMany(targetEntity=Material::class, inversedBy="tasks")
     */
    private $material;

    /**
     * @ORM\OneToMany(targetEntity=Process::class, mappedBy="task")
     */
    private $processes;

    /**
     * @ORM\ManyToMany(targetEntity=Component::class, mappedBy="task")
     */
    private $components;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectChangeRequest::class, inversedBy="tasks")
     */
    private $requestChange;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $color;

    public function __toString()
    {
        return $this->task_name;
        // TODO: Implement __toString() method.
    }

    public function __construct()
    {
        $this->material = new ArrayCollection();
        $this->processes = new ArrayCollection();
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskRef(): ?string
    {
        return $this->task_ref;
    }

    public function setTaskRef(string $task_ref): self
    {
        $this->task_ref = $task_ref;

        return $this;
    }

    public function getTaskName(): ?string
    {
        return $this->task_name;
    }

    public function setTaskName(string $task_name): self
    {
        $this->task_name = $task_name;

        return $this;
    }

    public function getTaskDescription(): ?string
    {
        return $this->task_description;
    }

    public function setTaskDescription(string $task_description): self
    {
        $this->task_description = $task_description;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getProgress(): ?float
    {
        return $this->progress;
    }

    public function setProgress(float $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getTaskCost(): ?int
    {
        return $this->task_cost;
    }

    public function setTaskCost(int $task_cost): self
    {
        $this->task_cost = $task_cost;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProjet(): ?Project
    {
        return $this->projet;
    }

    public function setProjet(?Project $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection|Material[]
     */
    public function getMaterial(): Collection
    {
        return $this->material;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->material->contains($material)) {
            $this->material[] = $material;
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        $this->material->removeElement($material);

        return $this;
    }

    /**
     * @return Collection|Process[]
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function addProcess(Process $process): self
    {
        if (!$this->processes->contains($process)) {
            $this->processes[] = $process;
            $process->setTask($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): self
    {
        if ($this->processes->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getTask() === $this) {
                $process->setTask(null);
            }
        }

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
            $component->addTask($this);
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        if ($this->components->removeElement($component)) {
            $component->removeTask($this);
        }

        return $this;
    }

    public function getRequestChange(): ?ProjectChangeRequest
    {
        return $this->requestChange;
    }

    public function setRequestChange(?ProjectChangeRequest $requestChange): self
    {
        $this->requestChange = $requestChange;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
