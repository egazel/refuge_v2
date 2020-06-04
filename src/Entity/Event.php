<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", mappedBy="eventParticipating")
     */
    private $participatingMembers;

    public function __construct()
    {
        $this->participatingMembers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getParticipatingMembers(): Collection
    {
        return $this->participatingMembers;
    }

    public function addParticipatingMember(Member $participatingMember): self
    {
        if (!$this->participatingMembers->contains($participatingMember)) {
            $this->participatingMembers[] = $participatingMember;
            $participatingMember->addEventParticipating($this);
        }

        return $this;
    }

    public function removeParticipatingMember(Member $participatingMember): self
    {
        if ($this->participatingMembers->contains($participatingMember)) {
            $this->participatingMembers->removeElement($participatingMember);
            $participatingMember->removeEventParticipating($this);
        }

        return $this;
    }
}
