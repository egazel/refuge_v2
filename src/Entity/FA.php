<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FARepository")
 */
class FA
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $houseType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasDog;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasCat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasKid;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canQuarantine;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $houseSize;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="isFA", cascade={"persist", "remove"})
     */
    private $userRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal", inversedBy="hostingFamily")
     */
    private $animalHosting;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHouseType(): ?string
    {
        return $this->houseType;
    }

    public function setHouseType(?string $houseType): self
    {
        $this->houseType = $houseType;

        return $this;
    }

    public function getHasDog(): ?bool
    {
        return $this->hasDog;
    }

    public function setHasDog(?bool $hasDog): self
    {
        $this->hasDog = $hasDog;

        return $this;
    }

    public function getHasCat(): ?bool
    {
        return $this->hasCat;
    }

    public function setHasCat(?bool $hasCat): self
    {
        $this->hasCat = $hasCat;

        return $this;
    }

    public function getHasKid(): ?bool
    {
        return $this->hasKid;
    }

    public function setHasKid(?bool $hasKid): self
    {
        $this->hasKid = $hasKid;

        return $this;
    }

    public function getCanQuarantine(): ?bool
    {
        return $this->canQuarantine;
    }

    public function setCanQuarantine(?bool $canQuarantine): self
    {
        $this->canQuarantine = $canQuarantine;

        return $this;
    }

    public function getHouseSize(): ?int
    {
        return $this->houseSize;
    }

    public function setHouseSize(?int $houseSize): self
    {
        $this->houseSize = $houseSize;

        return $this;
    }

    public function getUserRole(): ?User
    {
        return $this->userRole;
    }

    public function setUserRole(?User $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }

    public function getAnimalHosting(): ?Animal
    {
        return $this->animalHosting;
    }

    public function setAnimalHosting(?Animal $animalHosting): self
    {
        $this->animalHosting = $animalHosting;

        return $this;
    }
}
