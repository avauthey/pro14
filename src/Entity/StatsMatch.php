<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsMatchRepository")
 */
class StatsMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Journee", inversedBy="statsMatches")
     */
    private $journee;

    /**
     * @ORM\Column(type="integer")
     */
    private $possessionHome;

    /**
     * @ORM\Column(type="integer")
     */
    private $possessionAway;

    /**
     * @ORM\Column(type="integer")
     */
    private $occupationHome;

    /**
     * @ORM\Column(type="integer")
     */
    private $occupationAway;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJournee(): ?Journee
    {
        return $this->journee;
    }

    public function setJournee(?Journee $journee): self
    {
        $this->journee = $journee;

        return $this;
    }

    public function getPossessionHome(): ?int
    {
        return $this->possessionHome;
    }

    public function setPossessionHome(int $possessionHome): self
    {
        $this->possessionHome = $possessionHome;

        return $this;
    }

    public function getPossessionAway(): ?int
    {
        return $this->possessionAway;
    }

    public function setPossessionAway(int $possessionAway): self
    {
        $this->possessionAway = $possessionAway;

        return $this;
    }

    public function getOccupationHome(): ?int
    {
        return $this->occupationHome;
    }

    public function setOccupationHome(int $occupationHome): self
    {
        $this->occupationHome = $occupationHome;

        return $this;
    }

    public function getOccupationAway(): ?int
    {
        return $this->occupationAway;
    }

    public function setOccupationAway(int $occupationAway): self
    {
        $this->occupationAway = $occupationAway;

        return $this;
    }
}
