<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
    private $ref_project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_name;

    /**
     * @ORM\Column(type="text")
     */
    private $project_description;

    /**
     * @ORM\Column(type="date")
     */
    private $date_init_projet;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin_projet;

    /**
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     */
    private $maitre;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="projet")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=ProjectChangeRequest::class, mappedBy="project")
     */
    private $projectChangeRequests;

    /**
     * @ORM\OneToMany(targetEntity=Phase::class, mappedBy="project")
     */
    private $phases;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->projectChangeRequests = new ArrayCollection();
        $this->phases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefProject(): ?string
    {
        return $this->ref_project;
    }

    public function setRefProject(string $ref_project): self
    {
        $this->ref_project = $ref_project;

        return $this;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(string $project_name): self
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getProjectDescription(): ?string
    {
        return $this->project_description;
    }

    public function setProjectDescription(string $project_description): self
    {
        $this->project_description = $project_description;

        return $this;
    }

    public function getDateInitProjet(): ?\DateTimeInterface
    {
        return $this->date_init_projet;
    }

    public function setDateInitProjet(\DateTimeInterface $date_init_projet): self
    {
        $this->date_init_projet = $date_init_projet;

        return $this;
    }

    public function getDateFinProjet(): ?\DateTimeInterface
    {
        return $this->date_fin_projet;
    }

    public function setDateFinProjet(\DateTimeInterface $date_fin_projet): self
    {
        $this->date_fin_projet = $date_fin_projet;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getMaitre(): ?User
    {
        return $this->maitre;
    }

    public function setMaitre(?User $maitre): self
    {
        $this->maitre = $maitre;

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
            $task->setProjet($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProjet() === $this) {
                $task->setProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectChangeRequest[]
     */
    public function getProjectChangeRequests(): Collection
    {
        return $this->projectChangeRequests;
    }

    public function addProjectChangeRequest(ProjectChangeRequest $projectChangeRequest): self
    {
        if (!$this->projectChangeRequests->contains($projectChangeRequest)) {
            $this->projectChangeRequests[] = $projectChangeRequest;
            $projectChangeRequest->setProject($this);
        }

        return $this;
    }

    public function removeProjectChangeRequest(ProjectChangeRequest $projectChangeRequest): self
    {
        if ($this->projectChangeRequests->removeElement($projectChangeRequest)) {
            // set the owning side to null (unless already changed)
            if ($projectChangeRequest->getProject() === $this) {
                $projectChangeRequest->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Phase[]
     */
    public function getPhases(): Collection
    {
        return $this->phases;
    }

    public function addPhase(Phase $phase): self
    {
        if (!$this->phases->contains($phase)) {
            $this->phases[] = $phase;
            $phase->setProject($this);
        }

        return $this;
    }

    public function removePhase(Phase $phase): self
    {
        if ($this->phases->removeElement($phase)) {
            // set the owning side to null (unless already changed)
            if ($phase->getProject() === $this) {
                $phase->setProject(null);
            }
        }

        return $this;
    }

}
