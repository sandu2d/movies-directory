<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nationality;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Actor", mappedBy="nationality")
     */
    private $actors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Director", mappedBy="nationality")
     */
    private $directors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="country")
     */
    private $movies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Award", mappedBy="country")
     */
    private $awards;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->movies = new ArrayCollection();
        $this->awards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection|Actor[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
            $actor->setNationality($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
            // set the owning side to null (unless already changed)
            if ($actor->getNationality() === $this) {
                $actor->setNationality(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Director[]
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    public function addDirector(Director $director): self
    {
        if (!$this->directors->contains($director)) {
            $this->directors[] = $director;
            $director->setNationality($this);
        }

        return $this;
    }

    public function removeDirector(Director $director): self
    {
        if ($this->directors->contains($director)) {
            $this->directors->removeElement($director);
            // set the owning side to null (unless already changed)
            if ($director->getNationality() === $this) {
                $director->setNationality(null);
            }
        }

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
            $movie->setCountry($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getCountry() === $this) {
                $movie->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Award[]
     */
    public function getAwards(): Collection
    {
        return $this->awards;
    }

    public function addAward(Award $award): self
    {
        if (!$this->awards->contains($award)) {
            $this->awards[] = $award;
            $award->setCountry($this);
        }

        return $this;
    }

    public function removeAward(Award $award): self
    {
        if ($this->awards->contains($award)) {
            $this->awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getCountry() === $this) {
                $award->setCountry(null);
            }
        }

        return $this;
    }
}
