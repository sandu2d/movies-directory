<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorRepository")
 */
class Actor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $last_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="actors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nationality;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", mappedBy="actors")
     */
    private $movies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActorAward", mappedBy="actor")
     */
    private $actorAwards;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->actorAwards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getNationality(): ?Country
    {
        return $this->nationality;
    }

    public function setNationality(?Country $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addActor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            $movie->removeActor($this);
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
            $actorAward->setActor($this);
        }

        return $this;
    }

    public function removeActorAward(ActorAward $actorAward): self
    {
        if ($this->actorAwards->contains($actorAward)) {
            $this->actorAwards->removeElement($actorAward);
            // set the owning side to null (unless already changed)
            if ($actorAward->getActor() === $this) {
                $actorAward->setActor(null);
            }
        }

        return $this;
    }
}
