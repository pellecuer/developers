<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BadgeLabelRepository")
 */
class BadgeLabel
{

    const LEVEL = [
        0 => 'Débutant',
        1 => 'intermédiaire',
        2 => 'Confirmé',
        3 => 'Expert',
        4 => 'Jedi'
    ];

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Developer", mappedBy="BadgeLabel")
     */
    private $Developer;

    
    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    public function __construct()
    {
        $this->Developer = new ArrayCollection();
    }

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

    /**
     * @return Collection|Developer[]
     */
    public function getDeveloper(): Collection
    {
        return $this->Developer;
    }

    public function addDeveloper(Developer $developer): self
    {
        if (!$this->Developer->contains($developer)) {
            $this->Developer[] = $developer;
            $developer->addBadgeLabel($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): self
    {
        if ($this->Developer->contains($developer)) {
            $this->Developer->removeElement($developer);
            $developer->removeBadgeLabel($this);
        }

        return $this;
    }

    /**
     * Get the value of level
     */ 
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set the value of level
     *
     * @return  self
     */ 
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }
}
