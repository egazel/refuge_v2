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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="participatingMembers")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donation", mappedBy="memberDonating")
     */
    private $donation;

    public function __construct()
    {
        $this->animalsAdopted = new ArrayCollection();
        $this->event = new ArrayCollection();
        $this->donation = new ArrayCollection();
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

    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->contains($event)) {
            $this->event->removeElement($event);
        }

        return $this;
    }

    /**
     * @return Collection|Donation[]
     */
    public function getDonation(): Collection
    {
        return $this->donation;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donation->contains($donation)) {
            $this->donation[] = $donation;
            $donation->setMemberDonating($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donation->contains($donation)) {
            $this->donation->removeElement($donation);
            // set the owning side to null (unless already changed)
            if ($donation->getMemberDonating() === $this) {
                $donation->setMemberDonating(null);
            }
        }

        return $this;
    }

    public function __toString(){
        $idString = strval($this->getId());
        // to show the name of the Category in the select
        return $idString;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
