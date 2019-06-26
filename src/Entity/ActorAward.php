<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorAwardRepository")
 */
class ActorAward
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Actor", inversedBy="actorAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $actor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Award", inversedBy="actorAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $award;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AwardCategory", inversedBy="actorAwards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $award_category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActor(): ?Actor
    {
        return $this->actor;
    }

    public function setActor(?Actor $actor): self
    {
        $this->actor = $actor;

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
