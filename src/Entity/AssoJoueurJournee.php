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

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getEssais(): ?int
    {
        return $this->essais;
    }

    public function setEssais(?int $essais): self
    {
        $this->essais = $essais;

        return $this;
    }

    public function getTransformation(): ?int
    {
        return $this->transformation;
    }

    public function setTransformation(?int $transformation): self
    {
        $this->transformation = $transformation;

        return $this;
    }

    public function getPenalite(): ?int
    {
        return $this->penalite;
    }

    public function setPenalite(?int $penalite): self
    {
        $this->penalite = $penalite;

        return $this;
    }

    public function getDrops(): ?int
    {
        return $this->drops;
    }

    public function setDrops(?int $drops): self
    {
        $this->drops = $drops;

        return $this;
    }

    public function getPlacagesReussis(): ?int
    {
        return $this->placagesReussis;
    }

    public function setPlacagesReussis(?int $placagesReussis): self
    {
        $this->placagesReussis = $placagesReussis;

        return $this;
    }

    public function getPlacagesManques(): ?int
    {
        return $this->placagesManques;
    }

    public function setPlacagesManques(?int $placagesManques): self
    {
        $this->placagesManques = $placagesManques;

        return $this;
    }

    public function getAssist(): ?int
    {
        return $this->assist;
    }

    public function setAssist(?int $assist): self
    {
        $this->assist = $assist;

        return $this;
    }

    public function getOffload(): ?int
    {
        return $this->offload;
    }

    public function setOffload(?int $offload): self
    {
        $this->offload = $offload;

        return $this;
    }

    public function getPasse(): ?int
    {
        return $this->passe;
    }

    public function setPasse(?int $passe): self
    {
        $this->passe = $passe;

        return $this;
    }

    public function getCourse(): ?int
    {
        return $this->course;
    }

    public function setCourse(?int $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getMetreGagne(): ?int
    {
        return $this->metreGagne;
    }

    public function setMetreGagne(?int $metreGagne): self
    {
        $this->metreGagne = $metreGagne;

        return $this;
    }

    public function getPerce(): ?int
    {
        return $this->perce;
    }

    public function setPerce(?int $perce): self
    {
        $this->perce = $perce;

        return $this;
    }

    public function getDefenseurBattu(): ?int
    {
        return $this->defenseurBattu;
    }

    public function setDefenseurBattu(?int $defenseurBattu): self
    {
        $this->defenseurBattu = $defenseurBattu;

        return $this;
    }

    public function getPenaliteConcedee(): ?int
    {
        return $this->penaliteConcedee;
    }

    public function setPenaliteConcedee(?int $penaliteConcedee): self
    {
        $this->penaliteConcedee = $penaliteConcedee;

        return $this;
    }

    public function getCJ(): ?int
    {
        return $this->CJ;
    }

    public function setCJ(?int $CJ): self
    {
        $this->CJ = $CJ;

        return $this;
    }

    public function getCR(): ?int
    {
        return $this->CR;
    }

    public function setCR(?int $CR): self
    {
        $this->CR = $CR;

        return $this;
    }
}
