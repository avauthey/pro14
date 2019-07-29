<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JoueurRepository")
 */
class Joueur
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $villeNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paysNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $poids;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taille;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Poste", inversedBy="joueurs")
     */
    private $poste;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AssoJoueurEquipe", mappedBy="idJoueur")
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AssoJoueurJournee", mappedBy="joueur")
     */
    private $assoJoueurJournees;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->assoJoueurJournees = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getVilleNaissance()
    {
        return $this->villeNaissance;
    }

    public function setVilleNaissance(string $villeNaissance)
    {
        $this->villeNaissance = $villeNaissance;

        return $this;
    }

    public function getPaysNaissance()
    {
        return $this->paysNaissance;
    }

    public function setPaysNaissance(string $paysNaissance)
    {
        $this->paysNaissance = $paysNaissance;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto(string $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPoids()
    {
        return $this->poids;
    }

    public function setPoids(int $poids)
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTaille()
    {
        return $this->taille;
    }

    public function setTaille(int $taille)
    {
        $this->taille = $taille;

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

    /**
     * @return Collection|AssoJoueurEquipe[]
     */
    public function getEquipes()
    {
        return $this->equipes;
    }

    public function addEquipe(AssoJoueurEquipe $equipe)
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->setIdJoueur($this);
        }

        return $this;
    }

    public function removeEquipe(AssoJoueurEquipe $equipe)
    {
        if ($this->equipes->contains($equipe)) {
            $this->equipes->removeElement($equipe);
            // set the owning side to null (unless already changed)
            if ($equipe->getIdJoueur() === $this) {
                $equipe->setIdJoueur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AssoJoueurJournee[]
     */
    public function getAssoJoueurJournees(): Collection
    {
        return $this->assoJoueurJournees;
    }

    public function addAssoJoueurJournee(AssoJoueurJournee $assoJoueurJournee): self
    {
        if (!$this->assoJoueurJournees->contains($assoJoueurJournee)) {
            $this->assoJoueurJournees[] = $assoJoueurJournee;
            $assoJoueurJournee->setJoueur($this);
        }

        return $this;
    }

    public function removeAssoJoueurJournee(AssoJoueurJournee $assoJoueurJournee): self
    {
        if ($this->assoJoueurJournees->contains($assoJoueurJournee)) {
            $this->assoJoueurJournees->removeElement($assoJoueurJournee);
            // set the owning side to null (unless already changed)
            if ($assoJoueurJournee->getJoueur() === $this) {
                $assoJoueurJournee->setJoueur(null);
            }
        }

        return $this;
    }
}
