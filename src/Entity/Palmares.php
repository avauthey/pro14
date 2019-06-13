<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PalmaresRepository")
 */
class Palmares
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe", inversedBy="palmares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCompetition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $saison;

    public function getId()
    {
        return $this->id;
    }

    public function getEquipe()
    {
        return $this->equipe;
    }

    public function setEquipe(Equipe $equipe)
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getNomCompetition()
    {
        return $this->nomCompetition;
    }

    public function setNomCompetition(string $nomCompetition)
    {
        $this->nomCompetition = $nomCompetition;

        return $this;
    }

    public function getSaison()
    {
        return $this->saison;
    }

    public function setSaison(string $saison)
    {
        $this->saison = $saison;

        return $this;
    }
}
