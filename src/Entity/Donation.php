<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonationRepository")
 */
class Donation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="donationMaking")
     */
    private $memberDonating;

    public function __construct()
    {
        $this->memberDonating = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
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

    /**
     * @return Collection|Member[]
     */
    public function getMemberDonating(): Collection
    {
        return $this->memberDonating;
    }

    public function addMemberDonating(Member $memberDonating): self
    {
        if (!$this->memberDonating->contains($memberDonating)) {
            $this->memberDonating[] = $memberDonating;
            $memberDonating->setDonationMaking($this);
        }

        return $this;
    }

    public function removeMemberDonating(Member $memberDonating): self
    {
        if ($this->memberDonating->contains($memberDonating)) {
            $this->memberDonating->removeElement($memberDonating);
            // set the owning side to null (unless already changed)
            if ($memberDonating->getDonationMaking() === $this) {
                $memberDonating->setDonationMaking(null);
            }
        }

        return $this;
    }
}
