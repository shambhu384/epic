<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SectionRepository::class)
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"sections"})
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"show", "sections"})
     */
    private $name;

    /**
     * @Groups({"sections"})
     * @ORM\OneToMany(targetEntity=Investment::class, mappedBy="section")
     */
    private $investments;

    /**
     * @ORM\Column(type="text")
     * @Groups({"sections"})
     */
    private $summary;

    public function __construct()
    {
        $this->investments = new ArrayCollection();
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
     * @return Collection|Investment[]
     */
    public function getInvestments(): Collection
    {
        return $this->investments;
    }

    public function addInvestment(Investment $investment): self
    {
        if (!$this->investments->contains($investment)) {
            $this->investments[] = $investment;
            $investment->setSection($this);
        }

        return $this;
    }

    public function removeInvestment(Investment $investment): self
    {
        if ($this->investments->removeElement($investment)) {
            // set the owning side to null (unless already changed)
            if ($investment->getSection() === $this) {
                $investment->setSection(null);
            }
        }

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function __tostring()
    {
        return $this->name;
    }
}
