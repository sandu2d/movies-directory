<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $imdb_rate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $box_office;

    /**
     * @ORM\Column(type="string")
     */
    private $poster;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre", inversedBy="movies")
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Actor", inversedBy="movies")
     */
    private $actors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Director", inversedBy="movies")
     */
    private $directors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MovieAward", mappedBy="movie")
     */
    private $movieAwards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->movieAwards = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getImdbRate(): ?float
    {
        return $this->imdb_rate;
    }

    public function setImdbRate(?float $imdb_rate): self
    {
        $this->imdb_rate = $imdb_rate;

        return $this;
    }

    public function getBoxOffice(): ?string
    {
        return $this->box_office;
    }

    public function setBoxOffice(?string $box_office): self
    {
        $this->box_office = $box_office;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genre->contains($genre)) {
            $this->genre->removeElement($genre);
        }

        return $this;
    }

    public function setGenres($genres): self
    {
        $this->genre = $genres;
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
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
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
        }

        return $this;
    }

    public function removeDirector(Director $director): self
    {
        if ($this->directors->contains($director)) {
            $this->directors->removeElement($director);
        }

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
            $movieAward->setMovie($this);
        }

        return $this;
    }

    public function removeMovieAward(MovieAward $movieAward): self
    {
        if ($this->movieAwards->contains($movieAward)) {
            $this->movieAwards->removeElement($movieAward);
            // set the owning side to null (unless already changed)
            if ($movieAward->getMovie() === $this) {
                $movieAward->setMovie(null);
            }
        }

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }
}
