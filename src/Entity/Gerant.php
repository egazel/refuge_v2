<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GerantRepository")
 */
class Gerant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="isGerant", cascade={"persist", "remove"})
     */
    private $userRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal", inversedBy="adminAdding")
     */
    private $animalAdd;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnimalAdd(): ?Animal
    {
        return $this->animalAdd;
    }

    public function setAnimalAdd(?Animal $animalAdd): self
    {
        $this->animalAdd = $animalAdd;

        return $this;
    }
}
