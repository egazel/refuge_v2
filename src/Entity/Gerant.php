<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="gerant")
     */
    private $eventsOrganized;

    public function __construct()
    {
        $this->eventsOrganized = new ArrayCollection();
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
     * @return Collection|Event[]
     */
    public function getEventsOrganized(): Collection
    {
        return $this->eventsOrganized;
    }

    public function addEventsOrganized(Event $eventsOrganized): self
    {
        if (!$this->eventsOrganized->contains($eventsOrganized)) {
            $this->eventsOrganized[] = $eventsOrganized;
            $eventsOrganized->setGerant($this);
        }

        return $this;
    }

    public function removeEventsOrganized(Event $eventsOrganized): self
    {
        if ($this->eventsOrganized->contains($eventsOrganized)) {
            $this->eventsOrganized->removeElement($eventsOrganized);
            // set the owning side to null (unless already changed)
            if ($eventsOrganized->getGerant() === $this) {
                $eventsOrganized->setGerant(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        $idString = strval($this->getId());

        return $idString;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
