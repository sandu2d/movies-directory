<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieAwardRepository")
 */
class MovieAward
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="movieAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Award", inversedBy="movieAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $award;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AwardCategory", inversedBy="movieAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $award_category;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getAward(): ?Award
    {
        return $this->award;
    }

    public function setAward(?Award $award): self
    {
        $this->award = $award;

        return $this;
    }

    public function getAwardCategory(): ?AwardCategory
    {
        return $this->award_category;
    }

    public function setAwardCategory(?AwardCategory $award_category): self
    {
        $this->award_category = $award_category;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
