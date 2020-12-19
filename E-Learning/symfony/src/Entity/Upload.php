<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadRepository::class)
 */
class Upload
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cour::class, inversedBy="upload")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cour;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="upload")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_pdf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_vedio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCour(): ?Cour
    {
        return $this->cour;
    }

    public function setCour(?Cour $cour): self
    {
        $this->cour = $cour;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFilePdf()
    {
        return $this->file_pdf;
    }

    public function setFilePdf($file_pdf)
    {
        $this->file_pdf = $file_pdf;

        return $this;
    }

    public function getFileVedio(): ?string
    {
        return $this->file_vedio;
    }

    public function setFileVedio(?string $file_vedio): self
    {
        $this->file_vedio = $file_vedio;

        return $this;
    }
}
