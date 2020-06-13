<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceRepository")
 */
class Race
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Animal", mappedBy="race")
     */
    private $animalsWithRace;

    public function __construct()
    {
        $this->animalsWithRace = new ArrayCollection();
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

    /**
     * @return Collection|Animal[]
     */
    public function getAnimalsWithRace(): Collection
    {
        return $this->animalsWithRace;
    }

    public function addAnimalsWithRace(Animal $animalsWithRace): self
    {
        if (!$this->animalsWithRace->contains($animalsWithRace)) {
            $this->animalsWithRace[] = $animalsWithRace;
            $animalsWithRace->setRace($this);
        }

        return $this;
    }

    public function removeAnimalsWithRace(Animal $animalsWithRace): self
    {
        if ($this->animalsWithRace->contains($animalsWithRace)) {
            $this->animalsWithRace->removeElement($animalsWithRace);
            // set the owning side to null (unless already changed)
            if ($animalsWithRace->getRace() === $this) {
                $animalsWithRace->setRace(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
