<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AwardCategoryRepository")
 */
class AwardCategory
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
     * @ORM\OneToMany(targetEntity="App\Entity\MovieAward", mappedBy="award_category")
     */
    private $movieAwards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActorAward", mappedBy="award_category")
     */
    private $actorAwards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DirectorAward", mappedBy="award_category")
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
            $movieAward->setAwardCategory($this);
        }

        return $this;
    }

    public function removeMovieAward(MovieAward $movieAward): self
    {
        if ($this->movieAwards->contains($movieAward)) {
            $this->movieAwards->removeElement($movieAward);
            // set the owning side to null (unless already changed)
            if ($movieAward->getAwardCategory() === $this) {
                $movieAward->setAwardCategory(null);
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
            $actorAward->setAwardCategory($this);
        }

        return $this;
    }

    public function removeActorAward(ActorAward $actorAward): self
    {
        if ($this->actorAwards->contains($actorAward)) {
            $this->actorAwards->removeElement($actorAward);
            // set the owning side to null (unless already changed)
            if ($actorAward->getAwardCategory() === $this) {
                $actorAward->setAwardCategory(null);
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

    public function addDirectorAward(DirectorAward $directorAward): self
    {
        if (!$this->directorAwards->contains($directorAward)) {
            $this->directorAwards[] = $directorAward;
            $directorAward->setAwardCategory($this);
        }

        return $this;
    }

    public function removeDirectorAward(DirectorAward $directorAward): self
    {
        if ($this->directorAwards->contains($directorAward)) {
            $this->directorAwards->removeElement($directorAward);
            // set the owning side to null (unless already changed)
            if ($directorAward->getAwardCategory() === $this) {
                $directorAward->setAwardCategory(null);
            }
        }

        return $this;
    }
}
