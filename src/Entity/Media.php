<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 * @Vich\Uploadable
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ref_media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media_name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $indice;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $path;

    /**
     * @ORM\OneToMany(targetEntity=Process::class, mappedBy="process_path")
     */
    private $processes;


    /**
     * @Vich\UploadableField(mapping="upload_images", fileNameProperty="path")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function __construct()
    {
        $this->processes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefMedia(): ?string
    {
        return $this->ref_media;
    }

    public function setRefMedia(string $ref_media): self
    {
        $this->ref_media = $ref_media;

        return $this;
    }

    public function getMediaName(): ?string
    {
        return $this->media_name;
    }

    public function setMediaName(string $media_name): self
    {
        $this->media_name = $media_name;

        return $this;
    }

    public function getIndice(): ?string
    {
        return $this->indice;
    }

    public function setIndice(?string $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

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
            $process->setProcessPath($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): self
    {
        if ($this->processes->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getProcessPath() === $this) {
                $process->setProcessPath(null);
            }
        }

        return $this;
    }

}
