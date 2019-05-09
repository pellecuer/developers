<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeveloperRepository")
 */
class Developer
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\BadgeLabel", inversedBy="Developer")
     */
    private $BadgeLabel;

    public function __construct()
    {
        $this->BadgeLabel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|BadgeLabel[]
     */
    public function getBadgeLabel(): Collection
    {
        return $this->BadgeLabel;
    }

    public function addBadgeLabel(BadgeLabel $badgeLabel): self
    {
        if (!$this->BadgeLabel->contains($badgeLabel)) {
            $this->BadgeLabel[] = $badgeLabel;
        }

        return $this;
    }

    public function removeBadgeLabel(BadgeLabel $badgeLabel): self
    {
        if ($this->BadgeLabel->contains($badgeLabel)) {
            $this->BadgeLabel->removeElement($badgeLabel);
        }

        return $this;
    }
}
