<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AwardRepository")
 */
class Award
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
     * @ORM\Column(type="boolean")
     */
    private $is_international;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="awards")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MovieAward", mappedBy="award")
     */
    private $movieAwards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActorAward", mappedBy="award")
     */
    private $actorAwards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DirectorAward", mappedBy="award")
     */
    private $directorAwards;

    public function __construct()
    {
        $this->movieAwards = new ArrayCollection();
        $this->actorAwards = new ArrayCollection();
        $this->directorAwards = new ArrayCollection();
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

    public function getIsInternational(): ?bool
    {
        return $this->is_international;
    }

    public function setIsInternational(bool $is_international): self
    {
        $this->is_international = $is_international;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|MovieAward[]
     */
    public function getMovieAwards(): Collection
    {
        return $this->movieAwards;
    }

    public function addMovieAward(MovieAward $movieAward): self
    {
        if (!$this->movieAwards->contains($movieAward)) {
            $this->movieAwards[] = $movieAward;
            $movieAward->setAward($this);
        }

        return $this;
    }

    public function removeMovieAward(MovieAward $movieAward): self
    {
        if ($this->movieAwards->contains($movieAward)) {
            $this->movieAwards->removeElement($movieAward);
            // set the owning side to null (unless already changed)
            if ($movieAward->getAward() === $this) {
                $movieAward->setAward(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ActorAward[]
     */
    public function getActorAwards(): Collection
    {
        return $this->actorAwards;
    }

    public function addActorAward(ActorAward $actorAward): self
    {
        if (!$this->actorAwards->contains($actorAward)) {
            $this->actorAwards[] = $actorAward;
            $actorAward->setAward($this);
        }

        return $this;
    }

    public function removeActorAward(ActorAward $actorAward): self
    {
        if ($this->actorAwards->contains($actorAward)) {
            $this->actorAwards->removeElement($actorAward);
            // set the owning side to null (unless already changed)
            if ($actorAward->getAward() === $this) {
                $actorAward->setAward(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DirectorAward[]
     */
    public function getDirectorAwards(): Collection
    {
        return $this->directorAwards;
    }

    public function addAwardCategory(DirectorAward $directorAwards): self
    {
        if (!$this->directorAwards->contains($directorAwards)) {
            $this->directorAwards[] = $directorAwards;
            $directorAwards->setAward($this);
        }

        return $this;
    }

    public function removeAwardCategory(DirectorAward $directorAwards): self
    {
        if ($this->directorAwards->contains($directorAwards)) {
            $this->directorAwards->removeElement($directorAwards);
            // set the owning side to null (unless already changed)
            if ($directorAwards->getAward() === $this) {
                $directorAwards->setAward(null);
            }
        }

        return $this;
    }
}
