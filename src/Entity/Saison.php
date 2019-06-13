<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SaisonRepository")
 */
class Saison
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
     * @ORM\Column(type="string", length=3)
     */
    private $actuelle;

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

    public function getActuelle()
    {
        return $this->actuelle;
    }

    public function setActuelle(string $actuelle)
    {
        $this->actuelle = $actuelle;

        return $this;
    }
}
