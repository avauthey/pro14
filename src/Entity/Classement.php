<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassementRepository")
 */
class Classement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $saison;

    /**
     * @ORM\Column(type="integer")
     */
    private $journee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $conference;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe", inversedBy="classements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipe;

    /**
     * @ORM\Column(type="integer")
     */
    private $joue;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPoints;

    /**
     * @ORM\Column(type="integer")
     */
    private $victoire;

    /**
     * @ORM\Column(type="integer")
     */
    private $nul;

    /**
     * @ORM\Column(type="integer")
     */
    private $defaite;

    /**
     * @ORM\Column(type="integer")
     */
    private $BO;

    /**
     * @ORM\Column(type="integer")
     */
    private $BD;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $difference;

    /**
     * @ORM\Column(type="integer")
     */
    private $classement;

    public function getId()
    {
        return $this->id;
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

    public function getJournee()
    {
        return $this->journee;
    }

    public function setJournee(int $journee)
    {
        $this->journee = $journee;

        return $this;
    }

    public function getConference()
    {
        return $this->conference;
    }

    public function setConference(string $conference)
    {
        $this->conference = $conference;

        return $this;
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

    public function getJoue()
    {
        return $this->joue;
    }

    public function setJoue(int $joue)
    {
        $this->joue = $joue;

        return $this;
    }

    public function getNbPoints()
    {
        return $this->nbPoints;
    }

    public function setNbPoints(int $nbPoints)
    {
        $this->nbPoints = $nbPoints;

        return $this;
    }

    public function getVictoire()
    {
        return $this->victoire;
    }

    public function setVictoire(int $victoire)
    {
        $this->victoire = $victoire;

        return $this;
    }

    public function getNul()
    {
        return $this->nul;
    }

    public function setNul(int $nul)
    {
        $this->nul = $nul;

        return $this;
    }

    public function getDefaite()
    {
        return $this->defaite;
    }

    public function setDefaite(int $defaite)
    {
        $this->defaite = $defaite;

        return $this;
    }

    public function getBO()
    {
        return $this->BO;
    }

    public function setBO(int $BO)
    {
        $this->BO = $BO;

        return $this;
    }

    public function getBD()
    {
        return $this->BD;
    }

    public function setBD(int $BD)
    {
        $this->BD = $BD;

        return $this;
    }

    public function getDifference()
    {
        return $this->difference;
    }

    public function setDifference(string $difference)
    {
        $this->difference = $difference;

        return $this;
    }

    public function getClassement()
    {
        return $this->classement;
    }

    public function setClassement(int $classement)
    {
        $this->classement = $classement;

        return $this;
    }
}
