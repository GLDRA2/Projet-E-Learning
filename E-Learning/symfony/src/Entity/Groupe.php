<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    private $confirm;

    public function getConfirm(): ?string
    {
        return $this->confirm;
    }

    public function setConfirm(string $confirm): self
    {
        $this->confirm = $confirm;

        return $this;
    }

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="groupe")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Cour::class, inversedBy="groupe", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cours;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGroupe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeGroupe($this);
        }

        return $this;
    }

    public function getCours(): ?Cour
    {
        return $this->cours;
    }

    public function setCours(Cour $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}
