<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosteRepository")
 */
class Poste
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Joueur", mappedBy="poste")
     */
    private $joueurs;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    /**
     * @return Collection|Joueur[]
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur)
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
            $joueur->setPoste($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur)
    {
        if ($this->joueurs->contains($joueur)) {
            $this->joueurs->removeElement($joueur);
            // set the owning side to null (unless already changed)
            if ($joueur->getPoste() === $this) {
                $joueur->setPoste(null);
            }
        }

        return $this;
    }
}
