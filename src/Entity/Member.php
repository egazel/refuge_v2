<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal", inversedBy="adoptingMember")
     */
    private $animalAdoption;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="participatingMembers")
     */
    private $eventParticipating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Donation", inversedBy="memberDonating")
     */
    private $donationMaking;

    public function __construct()
    {
        $this->eventParticipating = new ArrayCollection();
    }

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

    public function getAnimalAdoption(): ?Animal
    {
        return $this->animalAdoption;
    }

    public function setAnimalAdoption(?Animal $animalAdoption): self
    {
        $this->animalAdoption = $animalAdoption;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventParticipating(): Collection
    {
        return $this->eventParticipating;
    }

    public function addEventParticipating(Event $eventParticipating): self
    {
        if (!$this->eventParticipating->contains($eventParticipating)) {
            $this->eventParticipating[] = $eventParticipating;
        }

        return $this;
    }

    public function removeEventParticipating(Event $eventParticipating): self
    {
        if ($this->eventParticipating->contains($eventParticipating)) {
            $this->eventParticipating->removeElement($eventParticipating);
        }

        return $this;
    }

    public function getDonationMaking(): ?Donation
    {
        return $this->donationMaking;
    }

    public function setDonationMaking(?Donation $donationMaking): self
    {
        $this->donationMaking = $donationMaking;

        return $this;
    }
}
