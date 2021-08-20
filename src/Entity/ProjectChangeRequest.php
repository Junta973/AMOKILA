<?php

namespace App\Entity;

use App\Repository\ProjectChangeRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectChangeRequestRepository::class)
 */
class ProjectChangeRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_creation;

    /**
     * @ORM\Column(type="text")
     */
    private $pcr_description;

    /**
     * @ORM\Column(type="text")
     */
    private $pcr_change_reason;

    /**
     * @ORM\Column(type="text")
     */
    private $impact_of_change;

    /**
     * @ORM\Column(type="text")
     */
    private $pcr_proposed_action;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $approval_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pcr_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pcr_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pcr_ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $approved_by;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Materials;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Components;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Request_by;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Priority;

    /**
     * @ORM\Column(type="integer")
     */
    private $Estimated_cost;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projectChangeRequests")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectChangeRequests")
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="requestChange")
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

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->date_de_creation;
    }

    public function setDateDeCreation(\DateTimeInterface $date_de_creation): self
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }

    public function getPcrDescription(): ?string
    {
        return $this->pcr_description;
    }

    public function setPcrDescription(string $pcr_description): self
    {
        $this->pcr_description = $pcr_description;

        return $this;
    }

    public function getPcrChangeReason(): ?string
    {
        return $this->pcr_change_reason;
    }

    public function setPcrChangeReason(string $pcr_change_reason): self
    {
        $this->pcr_change_reason = $pcr_change_reason;

        return $this;
    }

    public function getImpactOfChange(): ?string
    {
        return $this->impact_of_change;
    }

    public function setImpactOfChange(string $impact_of_change): self
    {
        $this->impact_of_change = $impact_of_change;

        return $this;
    }

    public function getPcrProposedAction(): ?string
    {
        return $this->pcr_proposed_action;
    }

    public function setPcrProposedAction(string $pcr_proposed_action): self
    {
        $this->pcr_proposed_action = $pcr_proposed_action;

        return $this;
    }

    public function getApprovalDate(): ?\DateTimeInterface
    {
        return $this->approval_date;
    }

    public function setApprovalDate(?\DateTimeInterface $approval_date): self
    {
        $this->approval_date = $approval_date;

        return $this;
    }

    public function getPcrStatus(): ?string
    {
        return $this->pcr_status;
    }

    public function setPcrStatus(string $pcr_status): self
    {
        $this->pcr_status = $pcr_status;

        return $this;
    }

    public function getPcrName(): ?string
    {
        return $this->pcr_name;
    }

    public function setPcrName(string $pcr_name): self
    {
        $this->pcr_name = $pcr_name;

        return $this;
    }

    public function getPcrRef(): ?string
    {
        return $this->pcr_ref;
    }

    public function setPcrRef(string $pcr_ref): self
    {
        $this->pcr_ref = $pcr_ref;

        return $this;
    }

    public function getApprovedBy(): ?string
    {
        return $this->approved_by;
    }

    public function setApprovedBy(string $approved_by): self
    {
        $this->approved_by = $approved_by;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->Materials;
    }

    public function setMaterials(string $Materials): self
    {
        $this->Materials = $Materials;

        return $this;
    }

    public function getComponents(): ?string
    {
        return $this->Components;
    }

    public function setComponents(string $Components): self
    {
        $this->Components = $Components;

        return $this;
    }

    public function getRequestBy(): ?string
    {
        return $this->Request_by;
    }

    public function setRequestBy(string $Request_by): self
    {
        $this->Request_by = $Request_by;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->Priority;
    }

    public function setPriority(string $Priority): self
    {
        $this->Priority = $Priority;

        return $this;
    }

    public function getEstimatedCost(): ?int
    {
        return $this->Estimated_cost;
    }

    public function setEstimatedCost(int $Estimated_cost): self
    {
        $this->Estimated_cost = $Estimated_cost;

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

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
            $task->setRequestChange($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getRequestChange() === $this) {
                $task->setRequestChange(null);
            }
        }

        return $this;
    }
}
