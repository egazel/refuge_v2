<?php

namespace App\Entity;

use App\Repository\HouseTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HouseTypeRepository::class)
 */
class HouseType
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
     * @ORM\OneToMany(targetEntity=FA::class, mappedBy="typeOfHouse")
     */
    private $faHouseType;

    public function __construct()
    {
        $this->faHouseType = new ArrayCollection();
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
     * @return Collection|FA[]
     */
    public function getFaHouseType(): Collection
    {
        return $this->faHouseType;
    }

    public function addFaHouseType(FA $faHouseType): self
    {
        if (!$this->faHouseType->contains($faHouseType)) {
            $this->faHouseType[] = $faHouseType;
            $faHouseType->setTypeOfHouse($this);
        }

        return $this;
    }

    public function removeFaHouseType(FA $faHouseType): self
    {
        if ($this->faHouseType->contains($faHouseType)) {
            $this->faHouseType->removeElement($faHouseType);
            // set the owning side to null (unless already changed)
            if ($faHouseType->getTypeOfHouse() === $this) {
                $faHouseType->setTypeOfHouse(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
