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
     * @ORM\ManyToMany(targetEntity="App\Entity\Membre", mappedBy="event")
     */
    private $participatingMembers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gerant", inversedBy="eventsOrganized")
     */
    private $gerant;

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

    public function getEvent() {
        return $this;
    }

    /**
     * @return Collection|Membre[]
     */
    public function getParticipatingMembers(): Collection
    {
        return $this->participatingMembers;
    }

    public function addParticipatingMember(Membre $participatingMember): self
    {
        if (!$this->participatingMembers->contains($participatingMember)) {
            $this->participatingMembers[] = $participatingMember;
            $participatingMember->addEvent($this);
        }

        return $this;
    }

    public function removeParticipatingMember(Membre $participatingMember): self
    {
        if ($this->participatingMembers->contains($participatingMember)) {
            $this->participatingMembers->removeElement($participatingMember);
            $participatingMember->removeEvent($this);
        }

        return $this;
    }

    public function getGerant(): ?Gerant
    {
        return $this->gerant;
    }

    public function setGerant(?Gerant $gerant): self
    {
        $this->gerant = $gerant;

        return $this;
    }
}
