<?php

namespace App\Entity;

use App\Repository\InvestmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=InvestmentRepository::class)
 */
class Investment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show", "sections"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show", "sections"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * Updated at
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @Groups({"show"})
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="investments")
     */
    private $section;

    /**
     * @ORM\Column(type="text")
     * @Groups({"sections"})
     */
    private $summary;

    /**
     * @ORM\OneToMany(targetEntity=UserInvestment::class, mappedBy="investement")
     */
    private $userInvestments;

    public function __construct()
    {
        $this->userInvestments = new ArrayCollection();
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($created)
    {
        $this->createdAt = $created;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updated)
    {
        $this->updatedAt = $updated;
        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

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

    /**
     * @return Collection|UserInvestment[]
     */
    public function getUserInvestments(): Collection
    {
        return $this->userInvestments;
    }

    public function addUserInvestment(UserInvestment $userInvestment): self
    {
        if (!$this->userInvestments->contains($userInvestment)) {
            $this->userInvestments[] = $userInvestment;
            $userInvestment->setInvestement($this);
        }

        return $this;
    }

    public function removeUserInvestment(UserInvestment $userInvestment): self
    {
        if ($this->userInvestments->removeElement($userInvestment)) {
            // set the owning side to null (unless already changed)
            if ($userInvestment->getInvestement() === $this) {
                $userInvestment->setInvestement(null);
            }
        }

        return $this;
    }
}
