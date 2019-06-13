<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipeRepository")
 */
class Equipe
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
     * @ORM\Column(type="string", length=255)
     */
    private $maillotDomicile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maillotExterieur;

    /**
     * @ORM\Column(type="string")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="text")
     */
    private $histoire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stade;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $capaciteStade;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Palmares", mappedBy="equipe")
     */
    private $palmares;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Classement", mappedBy="equipe")
     */
    private $classements;

    public function __construct()
    {
        $this->palmares = new ArrayCollection();
        $this->classements = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMaillotDomicile()
    {
        return $this->maillotDomicile;
    }

    public function setMaillotDomicile(string $maillotDomicile): self
    {
        $this->maillotDomicile = $maillotDomicile;

        return $this;
    }

    public function getMaillotExterieur()
    {
        return $this->maillotExterieur;
    }

    public function setMaillotExterieur(string $maillotExterieur): self
    {
        $this->maillotExterieur = $maillotExterieur;

        return $this;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setDateCreation(string $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getHistoire()
    {
        return $this->histoire;
    }

    public function setHistoire(string $histoire): self
    {
        $this->histoire = $histoire;

        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getStade()
    {
        return $this->stade;
    }

    public function setStade(string $stade): self
    {
        $this->stade = $stade;

        return $this;
    }

    public function getCapaciteStade()
    {
        return $this->capaciteStade;
    }

    public function setCapaciteStade(string $capaciteStade): self
    {
        $this->capaciteStade = $capaciteStade;

        return $this;
    }

    /**
     * @return Collection|Palmares[]
     */
    public function getPalmares(): Collection
    {
        return $this->palmares;
    }

    public function addPalmare(Palmares $palmare): self
    {
        if (!$this->palmares->contains($palmare)) {
            $this->palmares[] = $palmare;
            $palmare->setEquipe($this);
        }

        return $this;
    }

    public function removePalmare(Palmares $palmare): self
    {
        if ($this->palmares->contains($palmare)) {
            $this->palmares->removeElement($palmare);
            // set the owning side to null (unless already changed)
            if ($palmare->getEquipe() === $this) {
                $palmare->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Classement[]
     */
    public function getClassements(): Collection
    {
        return $this->classements;
    }

    public function addClassement(Classement $classement): self
    {
        if (!$this->classements->contains($classement)) {
            $this->classements[] = $classement;
            $classement->setEquipe($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): self
    {
        if ($this->classements->contains($classement)) {
            $this->classements->removeElement($classement);
            // set the owning side to null (unless already changed)
            if ($classement->getEquipe() === $this) {
                $classement->setEquipe(null);
            }
        }

        return $this;
    }
}
