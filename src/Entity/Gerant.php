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
}
