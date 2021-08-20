<?php

namespace App\Entity;

use App\Repository\PhaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhaseRepository::class)
 */
class Phase
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
    private $phase_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phase_description;

    /**
     * @ORM\Column(type="date")
     */
    private $project_phase_date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $project_phase_date_end;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="Phase")
     */
    private $projects;

    public function __toString()
    {
        return $this->phase_name;
        // TODO: Implement __toString() method.
    }

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhaseName(): ?string
    {
        return $this->phase_name;
    }

    public function setPhaseName(string $phase_name): self
    {
        $this->phase_name = $phase_name;

        return $this;
    }

    public function getPhaseDescription(): ?string
    {
        return $this->phase_description;
    }

    public function setPhaseDescription(string $phase_description): self
    {
        $this->phase_description = $phase_description;

        return $this;
    }

    public function getProjectPhaseDateStart(): ?\DateTimeInterface
    {
        return $this->project_phase_date_start;
    }

    public function setProjectPhaseDateStart(\DateTimeInterface $project_phase_date_start): self
    {
        $this->project_phase_date_start = $project_phase_date_start;

        return $this;
    }

    public function getProjectPhaseDateEnd(): ?\DateTimeInterface
    {
        return $this->project_phase_date_end;
    }

    public function setProjectPhaseDateEnd(\DateTimeInterface $project_phase_date_end): self
    {
        $this->project_phase_date_end = $project_phase_date_end;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setPhase($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getPhase() === $this) {
                $project->setPhase(null);
            }
        }

        return $this;
    }

}
