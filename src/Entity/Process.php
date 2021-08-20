<?php

namespace App\Entity;

use App\Repository\ProcessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProcessRepository::class)
 */
class Process
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
    private $ref_process;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $process_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $process_indice;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="processes")
     */
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="processes")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, inversedBy="processes", cascade={"persist"})
     */
    private $process_path;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, inversedBy="processes", cascade={"persist"})
     */
    private $document1_path;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist"})
     */
    private $document2_path;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist"})
     */
    private $document3_path;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist"})
     */
    private $document4_path;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefProcess(): ?string
    {
        return $this->ref_process;
    }

    public function setRefProcess(string $ref_process): self
    {
        $this->ref_process = $ref_process;

        return $this;
    }

    public function getProcessName(): ?string
    {
        return $this->process_name;
    }

    public function setProcessName(string $process_name): self
    {
        $this->process_name = $process_name;

        return $this;
    }

    public function getProcessIndice(): ?string
    {
        return $this->process_indice;
    }

    public function setProcessIndice(string $process_indice): self
    {
        $this->process_indice = $process_indice;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

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

    public function getProcessPath(): ?Media
    {
        return $this->process_path;
    }

    public function setProcessPath(?Media $process_path): self
    {
        $this->process_path = $process_path;

        return $this;
    }

    public function getDocument1Path(): ?Media
    {
        return $this->document1_path;
    }

    public function setDocument1Path(?Media $document1_path): self
    {
        $this->document1_path = $document1_path;

        return $this;
    }

    public function getDocument2Path(): ?Media
    {
        return $this->document2_path;
    }

    public function setDocument2Path(?Media $document2_path): self
    {
        $this->document2_path = $document2_path;

        return $this;
    }

    public function getDocument3Path(): ?Media
    {
        return $this->document3_path;
    }

    public function setDocument3Path(?Media $document3_path): self
    {
        $this->document3_path = $document3_path;

        return $this;
    }

    public function getDocument4Path(): ?Media
    {
        return $this->document4_path;
    }

    public function setDocument4Path(?Media $document4_path): self
    {
        $this->document4_path = $document4_path;

        return $this;
    }

}
