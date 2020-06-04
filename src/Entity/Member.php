<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="isMember", cascade={"persist", "remove"})
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
