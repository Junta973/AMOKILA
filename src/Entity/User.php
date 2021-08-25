<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $skills;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contrat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hourly_fee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;


    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="user")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=Process::class, mappedBy="user")
     */
    private $processes;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }


    public function __toString()
    {
        return $this->email;
        // TODO: Implement __toString() method.
    }

    /**
     * @ORM\OneToMany(targetEntity=ProjectChangeRequest::class, mappedBy="user")
     */
    private $projectChangeRequests;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="projectOwner")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=ProjectChangeRequest::class, mappedBy="approuvedBy")
     */
    private $pcrApprouvedbyuser;

    /**
     * @ORM\OneToMany(targetEntity=ProjectChangeRequest::class, mappedBy="requestedBy")
     */
    private $pcrRequestedbyuser;

    /**
     * @ORM\ManyToMany(targetEntity=Task::class, mappedBy="assignedTo")
     */
    private $assignedTasks;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->processes = new ArrayCollection();
        $this->projectChangeRequests = new ArrayCollection();
        $this->pcrApprouvedbyuser = new ArrayCollection();
        $this->pcrRequestedbyuser = new ArrayCollection();
        $this->assignedTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getContrat(): ?string
    {
        return $this->contrat;
    }

    public function setContrat(?string $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getHourlyFee(): ?int
    {
        return $this->hourly_fee;
    }

    public function setHourlyFee(?int $hourly_fee): self
    {
        $this->hourly_fee = $hourly_fee;

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
            $task->setUser($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getUser() === $this) {
                $task->setUser(null);
            }
        }

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
            $process->setUser($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): self
    {
        if ($this->processes->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getUser() === $this) {
                $process->setUser(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Media
    {
        return $this->avatar;
    }

    public function setAvatar(?Media $avatar): self
    {
        $this->avatar = $avatar;

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
            $projectChangeRequest->setUser($this);
        }

        return $this;
    }

    public function removeProjectChangeRequest(ProjectChangeRequest $projectChangeRequest): self
    {
        if ($this->projectChangeRequests->removeElement($projectChangeRequest)) {
            // set the owning side to null (unless already changed)
            if ($projectChangeRequest->getUser() === $this) {
                $projectChangeRequest->setUser(null);
            }
        }

        return $this;
    }

    public function hasRole($role){
        return in_array($role,$this->roles);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills): void
    {
        $this->skills = $skills;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level): void
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param mixed $departement
     */
    public function setDepartement($departement): void
    {
        $this->departement = $departement;
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
            $project->setProjectOwner($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getProjectOwner() === $this) {
                $project->setProjectOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectChangeRequest[]
     */
    public function getPcrApprouvedbyuser(): Collection
    {
        return $this->pcrApprouvedbyuser;
    }

    public function addPcrApprouvedbyuser(ProjectChangeRequest $pcrApprouvedbyuser): self
    {
        if (!$this->pcrApprouvedbyuser->contains($pcrApprouvedbyuser)) {
            $this->pcrApprouvedbyuser[] = $pcrApprouvedbyuser;
            $pcrApprouvedbyuser->setApprouvedBy($this);
        }

        return $this;
    }

    public function removePcrApprouvedbyuser(ProjectChangeRequest $pcrApprouvedbyuser): self
    {
        if ($this->pcrApprouvedbyuser->removeElement($pcrApprouvedbyuser)) {
            // set the owning side to null (unless already changed)
            if ($pcrApprouvedbyuser->getApprouvedBy() === $this) {
                $pcrApprouvedbyuser->setApprouvedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectChangeRequest[]
     */
    public function getPcrRequestedbyuser(): Collection
    {
        return $this->pcrRequestedbyuser;
    }

    public function addPcrRequestedbyuser(ProjectChangeRequest $pcrRequestedbyuser): self
    {
        if (!$this->pcrRequestedbyuser->contains($pcrRequestedbyuser)) {
            $this->pcrRequestedbyuser[] = $pcrRequestedbyuser;
            $pcrRequestedbyuser->setRequestedBy($this);
        }

        return $this;
    }

    public function removePcrRequestedbyuser(ProjectChangeRequest $pcrRequestedbyuser): self
    {
        if ($this->pcrRequestedbyuser->removeElement($pcrRequestedbyuser)) {
            // set the owning side to null (unless already changed)
            if ($pcrRequestedbyuser->getRequestedBy() === $this) {
                $pcrRequestedbyuser->setRequestedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getAssignedTasks(): Collection
    {
        return $this->assignedTasks;
    }

    public function addAssignedTask(Task $assignedTask): self
    {
        if (!$this->assignedTasks->contains($assignedTask)) {
            $this->assignedTasks[] = $assignedTask;
            $assignedTask->addAssignedTo($this);
        }

        return $this;
    }

    public function removeAssignedTask(Task $assignedTask): self
    {
        if ($this->assignedTasks->removeElement($assignedTask)) {
            $assignedTask->removeAssignedTo($this);
        }

        return $this;
    }

}
