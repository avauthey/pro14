<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssoJoueurEquipeRepository")
 */
class AssoJoueurEquipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Joueur", inversedBy="equipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idJoueur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe", inversedBy="joueurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEquipe;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $saison;

    public function getId()
    {
        return $this->id;
    }

    public function getIdJoueur()
    {
        return $this->idJoueur;
    }

    public function setIdJoueur(Joueur $idJoueur)
    {
        $this->idJoueur = $idJoueur;

        return $this;
    }

    public function getIdEquipe()
    {
        return $this->idEquipe;
    }

    public function setIdEquipe(Equipe $idEquipe)
    {
        $this->idEquipe = $idEquipe;

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
