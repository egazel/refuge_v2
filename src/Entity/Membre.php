<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 */
class Membre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Animal", mappedBy="member")
     */
    private $animalsAdopted;

    public function __construct()
    {
        $this->animalsAdopted = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimalsAdopted(): Collection
    {
        return $this->animalsAdopted;
    }

    public function addAnimalsAdopted(Animal $animalsAdopted): self
    {
        if (!$this->animalsAdopted->contains($animalsAdopted)) {
            $this->animalsAdopted[] = $animalsAdopted;
            $animalsAdopted->setMember($this);
        }

        return $this;
    }

    public function removeAnimalsAdopted(Animal $animalsAdopted): self
    {
        if ($this->animalsAdopted->contains($animalsAdopted)) {
            $this->animalsAdopted->removeElement($animalsAdopted);
            // set the owning side to null (unless already changed)
            if ($animalsAdopted->getMember() === $this) {
                $animalsAdopted->setMember(null);
            }
        }

        return $this;
    }
}
