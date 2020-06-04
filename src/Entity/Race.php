<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceRepository")
 */
class Race
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal", inversedBy="animalRace")
     */
    private $animalsWithRace;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAnimalsWithRace(): ?Animal
    {
        return $this->animalsWithRace;
    }

    public function setAnimalsWithRace(?Animal $animalsWithRace): self
    {
        $this->animalsWithRace = $animalsWithRace;

        return $this;
    }
}
