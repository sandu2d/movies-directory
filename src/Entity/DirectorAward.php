<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DirectorAwardRepository")
 */
class DirectorAward
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Director", inversedBy="directorAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Award", inversedBy="award_category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $award;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AwardCategory", inversedBy="directorAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $award_category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDirector(): ?Director
    {
        return $this->director;
    }

    public function setDirector(?Director $director): self
    {
        $this->director = $director;

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
}
