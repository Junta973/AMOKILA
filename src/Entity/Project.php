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
     * @ORM\Column(type="float", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="float")
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="projet")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=ProjectChangeRequest::class, mappedBy="project")
     */
    private $projectChangeRequests;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projects")
     */
    private $maitre;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="maitre")
     */
    private $projects;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     */
    private $projectOwner;

    /**
     * @ORM\ManyToOne(targetEntity=Phase::class, inversedBy="projects")
     */
    private $Phase;

    public function __toString()
    {
        return $this->project_name;
        // TODO: Implement __toString() method.
    }

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->projectChangeRequests = new ArrayCollection();
        $this->phases = new ArrayCollection();
        $this->projects = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost): void
    {
        $this->cost = $cost;
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
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $budget
     */
    public function setBudget($budget): void
    {
        $this->budget = $budget;
    }

    public function getMaitre(): ?self
    {
        return $this->maitre;
    }

    public function setMaitre(?self $maitre): self
    {
        $this->maitre = $maitre;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(self $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setMaitre($this);
        }

        return $this;
    }

    public function removeProject(self $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getMaitre() === $this) {
                $project->setMaitre(null);
            }
        }

        return $this;
    }

    public function getProjectOwner(): ?User
    {
        return $this->projectOwner;
    }

    public function setProjectOwner(?User $projectOwner): self
    {
        $this->projectOwner = $projectOwner;

        return $this;
    }

    public function getPhase(): ?Phase
    {
        return $this->Phase;
    }

    public function setPhase(?Phase $Phase): self
    {
        $this->Phase = $Phase;

        return $this;
    }

    //
    public function calculCost(){
        $total = 0;

        if(count($this->tasks) != 0){
            foreach ($this->tasks as $task)
                $total += $task->getTaskCost();
        }

        return $total;
    }

}
