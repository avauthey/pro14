<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssoJoueurJourneeRepository")
 */
class AssoJoueurJournee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Journee", inversedBy="assoJoueurJournees")
     */
    private $journee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Joueur", inversedBy="assoJoueurJournees")
     */
    private $joueur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe", inversedBy="assoJoueurJournees")
     */
    private $equipe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Poste")
     */
    private $poste;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $essais;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $transformation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $penalite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $drops;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placagesReussis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placagesManques;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $assist;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $offload;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $course;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $metreGagne;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $perce;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $defenseurBattu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $penaliteConcedee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CJ;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CR;

    public function getId()
    {
        return $this->id;
    }

    public function getJournee()
    {
        return $this->journee;
    }

    public function setJournee(Journee $journee)
    {
        $this->journee = $journee;

        return $this;
    }

    public function getJoueur()
    {
        return $this->joueur;
    }

    public function setJoueur(Joueur $joueur)
    {
        $this->joueur = $joueur;

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

    public function getPoste()
    {
        return $this->poste;
    }

    public function setPoste(Poste $poste)
    {
        $this->poste = $poste;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero(int $numero)
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints(int $points)
    {
        $this->points = $points;

        return $this;
    }

    public function getEssais()
    {
        return $this->essais;
    }

    public function setEssais(int $essais)
    {
        $this->essais = $essais;

        return $this;
    }

    public function getTransformation()
    {
        return $this->transformation;
    }

    public function setTransformation(int $transformation)
    {
        $this->transformation = $transformation;

        return $this;
    }

    public function getPenalite()
    {
        return $this->penalite;
    }

    public function setPenalite(int $penalite)
    {
        $this->penalite = $penalite;

        return $this;
    }

    public function getDrops()
    {
        return $this->drops;
    }

    public function setDrops(int $drops)
    {
        $this->drops = $drops;

        return $this;
    }

    public function getPlacagesReussis()
    {
        return $this->placagesReussis;
    }

    public function setPlacagesReussis(int $placagesReussis)
    {
        $this->placagesReussis = $placagesReussis;

        return $this;
    }

    public function getPlacagesManques()
    {
        return $this->placagesManques;
    }

    public function setPlacagesManques(int $placagesManques)
    {
        $this->placagesManques = $placagesManques;

        return $this;
    }

    public function getAssist()
    {
        return $this->assist;
    }

    public function setAssist(int $assist)
    {
        $this->assist = $assist;

        return $this;
    }

    public function getOffload()
    {
        return $this->offload;
    }

    public function setOffload(int $offload)
    {
        $this->offload = $offload;

        return $this;
    }

    public function getPasse()
    {
        return $this->passe;
    }

    public function setPasse(int $passe)
    {
        $this->passe = $passe;

        return $this;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function setCourse(int $course)
    {
        $this->course = $course;

        return $this;
    }

    public function getMetreGagne()
    {
        return $this->metreGagne;
    }

    public function setMetreGagne(int $metreGagne)
    {
        $this->metreGagne = $metreGagne;

        return $this;
    }

    public function getPerce()
    {
        return $this->perce;
    }

    public function setPerce(int $perce)
    {
        $this->perce = $perce;

        return $this;
    }

    public function getDefenseurBattu()
    {
        return $this->defenseurBattu;
    }

    public function setDefenseurBattu(int $defenseurBattu)
    {
        $this->defenseurBattu = $defenseurBattu;

        return $this;
    }

    public function getPenaliteConcedee()
    {
        return $this->penaliteConcedee;
    }

    public function setPenaliteConcedee(int $penaliteConcedee)
    {
        $this->penaliteConcedee = $penaliteConcedee;

        return $this;
    }

    public function getCJ()
    {
        return $this->CJ;
    }

    public function setCJ(int $CJ)
    {
        $this->CJ = $CJ;

        return $this;
    }

    public function getCR()
    {
        return $this->CR;
    }

    public function setCR(int $CR)
    {
        $this->CR = $CR;

        return $this;
    }
}
